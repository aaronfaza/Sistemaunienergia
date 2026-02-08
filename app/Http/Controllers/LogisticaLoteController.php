<?php

namespace App\Http\Controllers;

use App\Models\LogisticaLote;
use App\Exports\LogisticaExport; // Asegúrate de tener creada esta clase
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LogisticaLoteController extends Controller
{
    /**
     * Muestra el listado con buscador y KPIs.
     */
    public function index(Request $request)
    {
        $query = LogisticaLote::query();

        // 1. Buscador funcional extendido
        // Nota: Cambié 'buscar' por 'search' para que coincida con el formulario de la vista
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
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

        // 2. Cálculos para los KPIs (clonados de la query filtrada)
        $totalRegistros = (clone $query)->count();
        $totalFinalizados = (clone $query)->where('estado', 'Finalizado')->count();
        $totalProceso = (clone $query)->where('estado', 'Proceso')->count();

        // 3. Obtención de datos paginados (manteniendo los parámetros de búsqueda)
        $lotes = $query->orderByDesc('id')
                       ->paginate(10)
                       ->withQueryString();

        return view('logistica_lotes.index', compact(
            'lotes', 
            'totalRegistros', 
            'totalFinalizados', 
            'totalProceso'
        ));

        $search = $request->input('search');

        $lotes = LogisticaLote::when($search, function ($query, $search) {
            return $query->where('cod_log', 'LIKE', "%{$search}%")
                        ->orWhere('responsable', 'LIKE', "%{$search}%")
                        ->orWhere('asunto', 'LIKE', "%{$search}%")
                        ->orWhere('numero_carta', 'LIKE', "%{$search}%");
        })
        ->orderByDesc('id')
        ->paginate(10)
        ->withQueryString(); // Esto mantiene el término buscado al cambiar de página

        return view('logistica_lotes.index', compact('lotes'));
    }

    /**
     * Almacena un nuevo registro.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_log'               => 'required|string|max:255|unique:logistica_lotes,cod_log',
            'carpeta'               => 'nullable|string|max:255',
            'estado'                => 'nullable|string|max:255',
            'responsable'           => 'nullable|string|max:255',
            'numero_carta'          => 'nullable|string|max:255',
            'asunto'                => 'nullable|string',
            'fecha_emision'         => 'nullable|date',
            'codigo_unico'          => 'nullable|string|max:255',
            'atencion'              => 'nullable|string|max:255',
            'observacion'           => 'nullable|string',
            'tipo_solicitud'        => 'nullable|string|max:255',
            'nro_oc_os'             => 'nullable|string|max:255',
            'emision_oc_os'         => 'nullable|date',
            'conformidad'           => 'nullable|string|max:255',
            'factura'               => 'nullable|string|max:255',
            'ruc'                   => 'nullable|string|max:11',
            'empresa_ganadora'      => 'nullable|string|max:255',
            'centro_costo'          => 'nullable|string|max:255',
            'moneda'                => 'nullable|string|max:20',
            'monto_igv'             => 'nullable|numeric',
            'forma_pago'            => 'nullable|string|max:255',
            'fecha_entrega'         => 'nullable|date',
            'orden_firmada'         => 'nullable|boolean',
            'ejecucion'             => 'nullable|string|max:255',
            'porcentaje_ejecucion'  => 'nullable|integer|min:0|max:100',
            'monto_factura'         => 'nullable|numeric',
            'fecha_vencimiento'     => 'nullable|date',
        ]);

        $data['created_by'] = Auth::id();

        LogisticaLote::create($data);

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro creado exitosamente.');
    }

    /**
     * Actualiza un registro existente.
     */
    public function update(Request $request, $id)
    {
        $lote = LogisticaLote::findOrFail($id);

        $data = $request->validate([
            'cod_log'               => 'required|string|max:255|unique:logistica_lotes,cod_log,'.$lote->id,
            'carpeta'               => 'nullable|string|max:255',
            'estado'                => 'nullable|string|max:255',
            'responsable'           => 'nullable|string|max:255',
            'numero_carta'          => 'nullable|string|max:255',
            'asunto'                => 'nullable|string',
            'fecha_emision'         => 'nullable|date',
            'codigo_unico'          => 'nullable|string|max:255',
            'atencion'              => 'nullable|string|max:255',
            'observacion'           => 'nullable|string',
            'tipo_solicitud'        => 'nullable|string|max:255',
            'nro_oc_os'             => 'nullable|string|max:255',
            'emision_oc_os'         => 'nullable|date',
            'conformidad'           => 'nullable|string|max:255',
            'factura'               => 'nullable|string|max:255',
            'ruc'                   => 'nullable|string|max:11',
            'empresa_ganadora'      => 'nullable|string|max:255',
            'centro_costo'          => 'nullable|string|max:255',
            'moneda'                => 'nullable|string|max:20',
            'monto_igv'             => 'nullable|numeric',
            'forma_pago'            => 'nullable|string|max:255',
            'fecha_entrega'         => 'nullable|date',
            'orden_firmada'         => 'nullable|boolean',
            'ejecucion'             => 'nullable|string|max:255',
            'porcentaje_ejecucion'  => 'nullable|integer|min:0|max:100',
            'monto_factura'         => 'nullable|numeric',
            'fecha_vencimiento'     => 'nullable|date',
        ]);

        $data['updated_by'] = Auth::id();
        $lote->update($data);

        return redirect()->route('logistica_lotes.index')->with('success', 'Registro actualizado correctamente.');
    }

    /**
     * Elimina un registro.
     */
    public function destroy($id)
    {
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
     * Actualización rápida de estado vía AJAX.
     */
    public function updateEstado(Request $request, $id)
    {
        $lote = LogisticaLote::findOrFail($id);
        $lote->estado = $request->estado;
        $lote->updated_by = Auth::id();
        $lote->save();

        return response()->json(['success' => true]);
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