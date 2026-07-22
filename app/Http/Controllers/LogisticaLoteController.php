<?php

namespace App\Http\Controllers;

use App\Models\CartaFis;
use App\Models\ControlCarta;
use App\Models\LogisticaLote;
use App\Models\User;
use App\Exports\LogisticaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'control_carta' => ControlCarta::whereDoesntHave('ropLote')->orderByDesc('id')->pluck('codigo', 'id'),
                'carta_fis' => CartaFis::whereDoesntHave('ropLote')->orderByDesc('id')->pluck('codigo', 'id'),
            ];
        }

        // Para el desplegable de Atención (solo Logística Lima) y de Responsable
        // (cualquier usuario registrado puede tener una firma pendiente).
        $usuariosLogistica = User::where('rol', 'logistica')->orderBy('name')->get(['id', 'name']);
        $usuariosRegistrados = User::orderBy('name')->get(['id', 'name']);

        return view('logistica_lotes.index', compact(
            'lotes', 'totalRegistros', 'totalEnProceso', 'totalEjecutado', 'totalAlerta',
            'cartasDisponibles', 'usuariosLogistica', 'usuariosRegistrados'
        ));
    }

    /**
     * Crea el registro ROP inicial. Solo administración: cod_log, la carta de
     * origen (Control de Cartas o Cartas FIS) y la observación. El resto lo
     * completa Logística Lima en update().
     */
    public function store(Request $request)
    {
        abort_if(!Auth::user()->tieneAccesoCompleto(), 403);

        $data = $request->validate([
            'cod_log' => 'required|string|max:255|unique:logistica_lotes,cod_log',
            'origen_tipo' => ['required', Rule::in(array_keys(self::ORIGENES_CARTA))],
            'origen_id' => 'required|integer',
            'asunto' => 'nullable|string',
            'observacion' => 'nullable|string',
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
        $lote->asunto = $data['asunto'] ?? null;
        $lote->observacion = $data['observacion'] ?? null;
        $lote->numero_carta = $carta->codigo;
        $lote->carta_type = $cartaClass;
        $lote->carta_id = $carta->id;
        $lote->estado = LogisticaLote::ESTADOS[0]; // 'PENDIENTE'
        $lote->save();

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro ROP creado. Logística Lima ya puede completarlo.');
    }

    /**
     * Completa/actualiza un registro existente. Solo Logística Lima: todo
     * excepto cod_log/carta de origen/observación (de administración).
     */
    public function update(Request $request, $id)
    {
        abort_if(!Auth::user()->esLogistica(), 403);

        $lote = LogisticaLote::findOrFail($id);

        $nombresLogistica = User::where('rol', 'logistica')->pluck('name')->all();

        $data = $request->validate([
            'carpeta' => 'nullable|string|max:255',
            'estado' => ['nullable', Rule::in(LogisticaLote::ESTADOS)],
            'servicio_valorizacion' => 'nullable|string|max:255',
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
        ]);

        if (($data['forma_pago'] ?? null) === 'OTRO' && !empty($data['forma_pago_otro'])) {
            $data['forma_pago'] = $data['forma_pago_otro'];
        }
        unset($data['forma_pago_otro']);

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

        $request->validate([
            'estado' => ['required', Rule::in(LogisticaLote::ESTADOS)],
        ]);

        $lote = LogisticaLote::findOrFail($id);
        $lote->estado = $request->estado;
        $lote->save();

        return response()->json(['success' => true]);
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
        return Excel::download(new LogisticaExport, $fileName);
    }
}
