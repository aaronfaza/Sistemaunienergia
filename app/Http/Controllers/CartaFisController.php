<?php

namespace App\Http\Controllers;

use App\Models\CartaFis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\RopDiskNoDisponibleException;
use App\Services\RopDocumentoService;

// IMPORTANTE: Estas clases son necesarias para el Excel
use App\Exports\CartasFisExport;
use Maatwebsite\Excel\Facades\Excel;

class CartaFisController extends Controller
{
    /**
     * Mostrar listado con buscador y paginación
     */
    public function index(Request $request)
    {
        $query = CartaFis::with('ropLote');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('servicio_compra', 'like', "%{$buscar}%")
                  ->orWhere('proveedor_elegido', 'like', "%{$buscar}%")
                  ->orWhere('area', 'like', "%{$buscar}%");
            });
        }

        $anio = in_array($request->get('anio'), ['2026', '2027'], true) ? $request->get('anio') : null;
        if ($anio) {
            $query->where('codigo', 'like', "%-{$anio}");
        }

        $cartas = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('cartas_fis.index', compact('cartas', 'anio'));
    }

    /**
     * Registrar una nueva Carta FIS
     */
    public function store(Request $request, RopDocumentoService $rop)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:255|unique:cartas_fis,codigo',
            'fecha' => 'required|date',
            'mes' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'servicio_compra' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string|max:255',
            'cotizaciones_consideradas' => 'nullable|string|max:255',
            'equipo' => 'nullable|string|max:255',
            'especificacion' => 'nullable|string|max:255',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string|max:255',
            'autorizado_por' => 'nullable|string|max:255',
            'factura_nro' => 'nullable|string|max:255',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'estado' => 'nullable|in:Pendiente,Rechazado,Ejecutado',
            'archivo_carta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_cotizacion' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'archivo_requerimiento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'carpeta_rop' => 'nullable|string|max:255',
        ]);

        [$data, $documentos] = $this->extraerDocumentos($data);

        try {
            $data = array_merge($data, $rop->guardarDocumentos(new CartaFis(), $documentos['archivos'], $documentos['carpeta']));
        } catch (RopDiskNoDisponibleException|\InvalidArgumentException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $data['created_by'] = Auth::id();
        CartaFis::create($data);

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS registrada correctamente.');
    }

    /**
     * Actualizar una Carta FIS existente
     */
    public function update(Request $request, $id, RopDocumentoService $rop)
    {
        $carta = CartaFis::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'required|string|max:255|unique:cartas_fis,codigo,'.$carta->id,
            'fecha' => 'required|date',
            'mes' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'servicio_compra' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'proveedor_elegido' => 'nullable|string|max:255',
            'cotizaciones_consideradas' => 'nullable|string|max:255',
            'equipo' => 'nullable|string|max:255',
            'especificacion' => 'nullable|string|max:255',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'nro_orden' => 'nullable|string|max:255',
            'autorizado_por' => 'nullable|string|max:255',
            'factura_nro' => 'nullable|string|max:255',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
            'estado' => 'required|in:Pendiente,Rechazado,Ejecutado',
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

        $data['updated_by'] = Auth::id();
        $carta->update($data);

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS actualizada correctamente.');
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

        $carta = CartaFis::findOrFail($id);
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

        $carta = CartaFis::findOrFail($id);

        abort_if(!$carta->archivo_carta, 422, 'No se puede verificar una carta sin el documento cargado.');

        $carta->firmado_verificado = true;
        $carta->verificado_por = Auth::id();
        $carta->verificado_en = now();
        $carta->save();

        return back()->with('success', 'Carta marcada como firmada y verificada.');
    }

    /**
     * Eliminar una carta
     */
    public function destroy($id)
    {
        $carta = CartaFis::findOrFail($id);
        $carta->delete();
        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS eliminada.');
    }

    /**
     * Exportar a Excel con diseño (vía Maatwebsite)
     */
    public function exportExcel()
    {
        $filename = "Reporte_FIS_" . now()->format('Y-m-d_His') . ".xlsx";
        return Excel::download(new CartasFisExport, $filename);
    }

    /**
     * Generar un Backup en CSV (Compatible con Excel)
     */
    public function backup()
    {
        $table = CartaFis::all();
        $filename = "backup_cartas_fis_" . now()->format('Y-m-d_H-i-s') . ".csv";

        $callback = function() use ($table) {
            $handle = fopen('php://output', 'w');
            // Añadir el BOM para que Excel detecte UTF-8 (tildes y eñes)
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Encabezados
            fputcsv($handle, [
                'ID', 'Código', 'Fecha', 'Mes', 'Área', 'Servicio/Compra', 'Descripción', 
                'Proveedor', 'Monto S/', 'Monto $', 'Estado', 'Creado por'
            ]);

            foreach ($table as $row) {
                fputcsv($handle, [
                    $row->id, $row->codigo, $row->fecha, $row->mes, $row->area, 
                    $row->servicio_compra, $row->descripcion, $row->proveedor_elegido, 
                    $row->monto_soles, $row->monto_dolares, $row->estado, $row->created_by
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }
}