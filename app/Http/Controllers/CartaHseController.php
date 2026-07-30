<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\CartaHse;
use App\Exports\CartasHseExport;
use App\Exceptions\RopDiskNoDisponibleException;
use App\Services\RopDocumentoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CartaHseController extends Controller
{
    /**
     * Listado + buscador
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $anio = in_array($request->get('anio'), ['2026', '2027'], true) ? $request->get('anio') : null;

        $cartas = CartaHse::with(['creador', 'modificador', 'ropLote'])
            ->when($buscar, function ($query, $buscar) {
                $query->where('codigo', 'like', "%{$buscar}%")
                      ->orWhere('servicio_compra', 'like', "%{$buscar}%")
                      ->orWhere('proveedor_elegido', 'like', "%{$buscar}%");
            })
            ->when($anio, function ($query, $anio) {
                $query->where('codigo', 'like', "%-{$anio}");
            })
            ->orderBy('fecha', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('cartas_hse.index', compact('cartas', 'buscar', 'anio'));
    }

    public function store(Request $request, RopDocumentoService $rop)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:cartas_hse,codigo',
            'fecha' => 'required|date',
            'mes' => 'nullable|string',
            'servicio_compra' => 'required|string',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string',
            'cotizaciones_consideradas' => 'nullable|string',
            'equipo' => 'nullable|string',
            'especificacion' => 'nullable|string',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string',
            'autorizado_por' => 'nullable|string',
            'factura_nro' => 'nullable|string',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'area' => 'nullable|string',
            'estado' => 'nullable|in:Pendiente,Rechazado,Ejecutado',
            'archivo_carta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_requerimiento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'carpeta_rop' => 'nullable|string|max:255',
        ]);

        $data['estado'] = $data['estado'] ?? 'Pendiente';

        [$data, $documentos] = $this->extraerDocumentos($data);

        try {
            $data = array_merge($data, $rop->guardarDocumentos(new CartaHse(), $documentos['archivos'], $documentos['carpeta']));
        } catch (RopDiskNoDisponibleException|\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        CartaHse::create($data);

        return redirect()
            ->route('cartas_hse.index')
            ->with('success', 'Carta registrada correctamente.');
    }

    /**
     * Actualizar carta
     */
    public function update(Request $request, $id, RopDocumentoService $rop)
    {
        $carta = CartaHse::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'required|unique:cartas_hse,codigo,' . $carta->id,
            'fecha' => 'required|date',
            'mes' => 'nullable|string',
            'servicio_compra' => 'required|string',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string',
            'cotizaciones_consideradas' => 'nullable|string',
            'equipo' => 'nullable|string',
            'especificacion' => 'nullable|string',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string',
            'autorizado_por' => 'nullable|string',
            'factura_nro' => 'nullable|string',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'area' => 'nullable|string',
            'estado' => 'nullable|in:Pendiente,Rechazado,Ejecutado',
            'archivo_carta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_requerimiento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'carpeta_rop' => 'nullable|string|max:255',
        ]);

        [$data, $documentos] = $this->extraerDocumentos($data);

        try {
            $data = array_merge($data, $rop->guardarDocumentos($carta, $documentos['archivos'], $documentos['carpeta']));
        } catch (RopDiskNoDisponibleException|\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $carta->update($data);

        return redirect()
            ->route('cartas_hse.index')
            ->with('success', 'Carta actualizada correctamente.');
    }

    /**
     * Separa del array validado los 3 archivos y la carpeta destino, para
     * pasarlos a RopDocumentoService sin que create()/update() intente
     * asignarlos como columnas crudas.
     */
    private function extraerDocumentos(array $data): array
    {
        $archivos = [
            'carta' => $data['archivo_carta'] ?? null,
            'cotizacion' => $data['archivo_cotizacion'] ?? null,
            'requerimiento' => $data['archivo_requerimiento'] ?? null,
        ];
        $carpeta = $data['carpeta_rop'] ?? null;

        unset($data['archivo_carta'], $data['archivo_cotizacion'], $data['archivo_requerimiento'], $data['carpeta_rop']);

        return [$data, ['archivos' => $archivos, 'carpeta' => $carpeta]];
    }

    /**
     * Eliminar carta
     */
    public function destroy($id)
    {
        CartaHse::findOrFail($id)->delete();

        return redirect()
            ->route('cartas_hse.index')
            ->with('success', 'Carta eliminada correctamente.');
    }

    /**
     * Exportar Excel (backup)
     */
    public function exportExcel(Request $request)
    {
        $buscar = $request->get('buscar');

        return Excel::download(
            new CartasHseExport($buscar),
            'backup_cartas_hse_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdfIndividual($id)
    {
        $carta = CartaHse::findOrFail($id);

        $pdf = Pdf::loadView('cartas_hse.pdf_individual', compact('carta'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Carta_SO_HSE_' . $carta->codigo . '.pdf');
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Rechazado,Ejecutado'
        ]);

        $carta = CartaHse::findOrFail($id);
        $carta->estado = $request->estado;
        $carta->save();

        return back();
    }

    /**
     * Historial de auditoría de una carta (quién creó/modificó/qué cambió).
     */
    public function historial($id)
    {
        $carta = CartaHse::findOrFail($id);

        $logs = $carta->auditLogs()
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
            'codigo' => $carta->codigo,
            'logs' => $logs,
        ]);
    }

    /**
     * Carpetas ROP disponibles para el selector del modal de subida (listado
     * en vivo del disco de red, con fallback a los ROP ya registrados en BD).
     */
    public function carpetasDisponibles(RopDocumentoService $rop)
    {
        return response()->json($rop->listarCarpetas());
    }

    /**
     * Sirve un documento (carta/cotizacion/requerimiento) para previsualizar
     * en el navegador y verificar visualmente que está firmado.
     */
    public function previsualizarDocumento($id, string $campo)
    {
        abort_unless(in_array($campo, RopDocumentoService::CAMPOS, true), 404);

        $carta = CartaHse::findOrFail($id);
        $path = $carta->{"archivo_{$campo}"};

        abort_if(
            !$path || !Storage::disk(RopDocumentoService::DISK)->exists($path),
            404,
            'Documento no disponible. Verifique la conexión con el servidor de archivos ROP2026.'
        );

        return Storage::disk(RopDocumentoService::DISK)->response($path);
    }

    /**
     * Marca la carta como firmada y verificada. Solo Admin, y solo después de
     * confirmar (en la previsualización) que el documento realmente está
     * firmado.
     */
    public function updateVerificacion($id)
    {
        abort_if(!Auth::user()->tieneAccesoCompleto(), 403);

        $carta = CartaHse::findOrFail($id);

        abort_if(!$carta->archivo_carta, 422, 'No se puede verificar una carta sin el documento cargado.');

        $carta->firmado_verificado = true;
        $carta->verificado_por = Auth::id();
        $carta->verificado_en = now();
        $carta->save();

        return back()->with('success', 'Carta marcada como firmada y verificada.');
    }
}
