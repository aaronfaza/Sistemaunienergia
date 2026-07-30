<?php

namespace App\Http\Controllers;

use App\Models\CartaFis;
use App\Models\CartaIpf;
use App\Models\CartaMan;
use App\Models\CartaLog;
use App\Models\CartaHse;
use App\Models\ControlCarta;
use App\Models\LogisticaLote;
use App\Models\User;
use App\Exports\LogisticaBackupExport;
use App\Exceptions\RopDiskNoDisponibleException;
use App\Services\RopDocumentoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LogisticaLoteController extends Controller
{
    /**
     * Modelos de carta a los que se puede vincular un ROP, mapeados a la
     * clave que usa el formulario ('origen_tipo').
     */
    private const ORIGENES_CARTA = [
        'control_carta' => ControlCarta::class,
        'carta_fis' => CartaFis::class,
        'carta_ipf' => CartaIpf::class,
        'carta_man' => CartaMan::class,
        'carta_log' => CartaLog::class,
        'carta_hse' => CartaHse::class,
    ];

    /**
     * Muestra el listado con buscador y KPIs.
     */
    public function index(Request $request)
    {
        $query = LogisticaLote::with(['creador', 'modificador', 'carta', 'responsableFirma']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cod_log', 'like', "%{$search}%")
                  ->orWhere('responsable', 'like', "%{$search}%")
                  ->orWhere('numero_carta', 'like', "%{$search}%")
                  ->orWhere('codigo_unico', 'like', "%{$search}%")
                  ->orWhere('asunto', 'like', "%{$search}%")
                  ->orWhere('ruc', 'like', "%{$search}%")
                  ->orWhere('empresa_ganadora', 'like', "%{$search}%")
                  ->orWhere('factura', 'like', "%{$search}%")
                  ->orWhere('carpeta', 'like', "%{$search}%");
            });
        }

        if ($request->filled('estado_filtro') && in_array($request->estado_filtro, LogisticaLote::ESTADOS, true)) {
            $query->where('estado', $request->estado_filtro);
        }

        $totalRegistros = (clone $query)->count();
        $totalEnProceso = (clone $query)->whereIn('estado', ['EN REVISION', 'EN PROCESO', 'EN EJECUCION', 'BUENA PRO'])->count();
        $totalEjecutado = (clone $query)->where('estado', 'EJECUTADO')->count();
        $totalAlerta = (clone $query)->whereIn('estado', ['ORDEN VENCIDA', 'OBSERVADO'])->count();

        $lotes = $query->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $cartasDisponibles = [];
        if (Auth::user()->tieneAccesoCompleto()) {
            $cartasDisponibles = [
                'control_carta' => ControlCarta::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
                'carta_fis' => CartaFis::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
                'carta_ipf' => CartaIpf::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
                'carta_man' => CartaMan::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
                'carta_log' => CartaLog::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
                'carta_hse' => CartaHse::whereDoesntHave('ropLote')->orderByDesc('id')->get(['id', 'codigo', 'descripcion']),
            ];
        }

        // Para el desplegable de Atención (solo Logística Lima) y de Responsable
        // (cualquier usuario registrado puede tener una firma pendiente).
        $usuariosLogistica = User::where('rol', 'logistica')->orderBy('name')->get(['id', 'name']);
        $usuariosRegistrados = User::orderBy('name')->get(['id', 'name']);

        // Alerta para el usuario logueado: expedientes donde él es el
        // responsable de firma y todavía no llegan a un estado final.
        $documentosPendientesFirma = LogisticaLote::where('responsable_id', Auth::id())
            ->whereNotIn('estado', ['EJECUTADO', 'ANULADO'])
            ->orderByDesc('id')
            ->get(['id', 'cod_log', 'asunto', 'estado']);

        // Equipo de Logística Lima: quién está activo ahora mismo y su
        // última conexión (mismo criterio que "Usuarios activos" de Bienvenida).
        $equipoLogistica = User::where('rol', 'logistica')
            ->orderByDesc('last_login_at')
            ->get(['id', 'name', 'last_login_at', 'foto_perfil']);

        return view('logistica_lotes.index', compact(
            'lotes', 'totalRegistros', 'totalEnProceso', 'totalEjecutado', 'totalAlerta',
            'cartasDisponibles', 'usuariosLogistica', 'usuariosRegistrados',
            'documentosPendientesFirma', 'equipoLogistica'
        ));
    }

    /**
     * Crea el registro ROP inicial. Solo administración: cod_log, la carta de
     * origen (Control de Cartas o Cartas FIS), la observación, y — nuevo —
     * los documentos (carta, cotización, requerimiento) firmados o no, que se
     * guardan directamente en la carpeta de red que coincide con cod_log
     * (ej. cod_log="ROP260298" → carpeta "ROP260298" dentro de ROP2026). El
     * resto lo completa Logística Lima en update(), pero solo una vez que
     * Admin haya verificado los documentos (ver updateVerificacion()).
     */
    public function store(Request $request, RopDocumentoService $rop)
    {
        abort_if(!Auth::user()->tieneAccesoCompleto(), 403);

        $data = $request->validate([
            'cod_log' => 'required|string|max:255|unique:logistica_lotes,cod_log',
            'origen_tipo' => ['required', Rule::in(array_keys(self::ORIGENES_CARTA))],
            'origen_id' => 'required|integer',
            'asunto' => 'nullable|string',
            'observacion' => 'nullable|string',
            'archivo_carta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_carta_jefe_operaciones' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_4' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_5' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion_6' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_requerimiento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $cartaClass = self::ORIGENES_CARTA[$data['origen_tipo']];
        $carta = $cartaClass::findOrFail($data['origen_id']);

        if (LogisticaLote::where('carta_type', $cartaClass)->where('carta_id', $carta->id)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Esa carta ya tiene un ROP asociado.');
        }

        $lote = new LogisticaLote();
        $lote->cod_log = $data['cod_log'];
        // Se nombra sola al registrar, con la ruta real absoluta en el
        // servidor (sigue el disco 'rop2026' configurado, así que se ajusta
        // sola el día que ese disco pase a apuntar al mount de red real).
        $lote->carpeta = Storage::disk('rop2026')->path($data['cod_log']);
        $lote->asunto = $data['asunto'] ?? null;
        $lote->observacion = $data['observacion'] ?? null;
        $lote->numero_carta = $carta->codigo;
        $lote->carta_type = $cartaClass;
        $lote->carta_id = $carta->id;
        $lote->estado = LogisticaLote::ESTADOS[0]; // 'PENDIENTE'

        try {
            // La carpeta se crea siempre, aunque no se suba ningún archivo
            // todavía — así el expediente queda listo para recibir documentos
            // más tarde (subidos desde el sistema o copiados manualmente).
            $rop->crearCarpeta($data['cod_log']);

            $documentos = $rop->guardarDocumentos($lote, [
                'carta' => $data['archivo_carta'] ?? null,
                'carta_jefe_operaciones' => $data['archivo_carta_jefe_operaciones'] ?? null,
                'cotizacion_1' => $data['archivo_cotizacion_1'] ?? null,
                'cotizacion_2' => $data['archivo_cotizacion_2'] ?? null,
                'cotizacion_3' => $data['archivo_cotizacion_3'] ?? null,
                'cotizacion_4' => $data['archivo_cotizacion_4'] ?? null,
                'cotizacion_5' => $data['archivo_cotizacion_5'] ?? null,
                'cotizacion_6' => $data['archivo_cotizacion_6'] ?? null,
                'requerimiento' => $data['archivo_requerimiento'] ?? null,
            ], $data['cod_log']);
        } catch (RopDiskNoDisponibleException|\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $lote->fill($documentos);
        $lote->save();

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro ROP creado. Logística Lima ya puede completarlo una vez verificado.');
    }

    /**
     * Completa/actualiza un registro existente. Solo Logística Lima: todo
     * excepto cod_log/carta de origen/observación (de administración).
     */
    public function update(Request $request, $id, RopDocumentoService $rop)
    {
        abort_if(!Auth::user()->esLogistica(), 403);

        $lote = LogisticaLote::findOrFail($id);

        abort_if(!$lote->firmado_verificado, 403, 'Este expediente aún no ha sido verificado como firmado por administración.');

        $nombresLogistica = User::where('rol', 'logistica')->pluck('name')->all();

        $data = $request->validate([
            'carpeta' => 'nullable|string|max:255',
            'estado' => ['nullable', Rule::in(LogisticaLote::ESTADOS)],
            'fecha_emision' => 'nullable|date',
            'codigo_unico' => 'nullable|string|max:255',
            'atencion' => ['nullable', Rule::in($nombresLogistica)],
            'responsable_id' => 'nullable|exists:users,id',
            'tipo_solicitud' => ['nullable', Rule::in(LogisticaLote::TIPOS_SOLICITUD)],
            'nro_oc_os' => 'nullable|string|max:255',
            'emision_oc_os' => 'nullable|date',
            'factura' => 'nullable|string|max:255',
            'ruc' => 'nullable|string|max:11',
            'empresa_ganadora' => 'nullable|string|max:255',
            'centro_costo' => 'nullable|string|max:255',
            'moneda' => ['nullable', Rule::in(LogisticaLote::MONEDAS)],
            'monto_igv' => 'nullable|numeric',
            'forma_pago' => 'nullable|string|max:255',
            'forma_pago_otro' => 'nullable|string|max:255',
            'fecha_entrega' => 'nullable|date',
            'orden_firmada' => 'nullable|boolean',
            'ejecucion' => ['nullable', Rule::in(LogisticaLote::EJECUCIONES)],
            'porcentaje_ejecucion' => 'nullable|integer|min:0|max:100',
            'monto_factura' => 'nullable|numeric',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'archivo_orden' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_acta_comite' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        if (($data['forma_pago'] ?? null) === 'OTRO' && !empty($data['forma_pago_otro'])) {
            $data['forma_pago'] = $data['forma_pago_otro'];
        }
        unset($data['forma_pago_otro']);

        $archivos = [
            'orden' => $data['archivo_orden'] ?? null,
            'acta_comite' => $data['archivo_acta_comite'] ?? null,
        ];
        unset($data['archivo_orden'], $data['archivo_acta_comite']);

        try {
            $data = array_merge($data, $rop->guardarDocumentos($lote, $archivos, $lote->cod_log));
        } catch (RopDiskNoDisponibleException|\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $lote->update($data);

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Elimina un registro. Solo administración.
     */
    public function destroy($id)
    {
        abort_if(!Auth::user()->tieneAccesoCompleto(), 403);

        $lote = LogisticaLote::findOrFail($id);
        $lote->delete();

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro eliminado correctamente.');
    }

    /**
     * Genera y descarga el reporte PDF de un lote individual.
     */
    public function exportPdf($id)
    {
        $lote = LogisticaLote::findOrFail($id);

        $pdf = Pdf::loadView('reportes.pdf_lote', compact('lote'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('Reporte-'.$lote->cod_log.'.pdf');
    }

    /**
     * Actualización rápida de estado vía AJAX. Solo Logística Lima.
     */
    public function updateEstado(Request $request, $id)
    {
        abort_if(!Auth::user()->esLogistica(), 403);

        $lote = LogisticaLote::findOrFail($id);

        abort_if(!$lote->firmado_verificado, 403, 'Este expediente aún no ha sido verificado como firmado por administración.');

        $request->validate([
            'estado' => ['required', Rule::in(LogisticaLote::ESTADOS)],
        ]);

        $lote->estado = $request->estado;
        $lote->save();

        return response()->json(['success' => true]);
    }

    /**
     * Sirve un documento (carta/cotizacion/requerimiento) del expediente para
     * previsualizar en el navegador y verificar visualmente que está firmado.
     */
    public function previsualizarDocumento($id, string $campo)
    {
        abort_unless(in_array($campo, RopDocumentoService::CAMPOS, true), 404);

        $lote = LogisticaLote::findOrFail($id);
        $path = $lote->{"archivo_{$campo}"};

        abort_if(
            !$path || !Storage::disk(RopDocumentoService::DISK)->exists($path),
            404,
            'Documento no disponible. Verifique la conexión con el servidor de archivos ROP2026.'
        );

        return Storage::disk(RopDocumentoService::DISK)->response($path);
    }

    /**
     * Marca el expediente como firmado y verificado. Solo Admin, y solo
     * después de confirmar (en la previsualización) que el documento
     * realmente está firmado. Desbloquea el expediente para Logística Lima.
     */
    public function updateVerificacion($id)
    {
        abort_if(!Auth::user()->tieneAccesoCompleto(), 403);

        $lote = LogisticaLote::findOrFail($id);

        abort_if(!$lote->archivo_carta, 422, 'No se puede verificar un expediente sin el documento de la carta cargado.');

        $lote->firmado_verificado = true;
        $lote->verificado_por = Auth::id();
        $lote->verificado_en = now();
        $lote->save();

        return back()->with('success', 'Expediente marcado como firmado y verificado.');
    }

    /**
     * Historial de auditoría de un ROP (quién creó/modificó/qué cambió).
     */
    public function historial($id)
    {
        $lote = LogisticaLote::findOrFail($id);

        $logs = $lote->auditLogs()
            ->with('usuario:id,name')
            ->get()
            ->map(function ($log) {
                return [
                    'accion' => $log->accion,
                    'usuario' => $log->usuario->name ?? 'Sistema',
                    'fecha' => optional($log->created_at)->format('d/m/Y H:i'),
                    'cambios' => $log->cambios,
                ];
            });

        return response()->json([
            'codigo' => $lote->cod_log,
            'logs' => $logs,
        ]);
    }

    /**
     * Exporta el backup completo a Excel con el diseño corporativo.
     */
    public function exportExcel()
    {
        $fileName = 'Backup_Logistica_' . now('America/Lima')->format('d-m-Y_His') . '.xlsx';
        return Excel::download(new LogisticaBackupExport, $fileName);
    }
}
