<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\CartaLog;
use App\Exports\CartasLogExport;
use Maatwebsite\Excel\Facades\Excel;

class CartaLogController extends Controller
{
    /**
     * Listado + buscador
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $anio = in_array($request->get('anio'), ['2026', '2027'], true) ? $request->get('anio') : null;

        $cartas = CartaLog::with(['creador', 'modificador', 'ropLote'])
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

        return view('cartas_log.index', compact('cartas', 'buscar', 'anio'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:cartas_log,codigo',
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
        ]);

        $data['estado'] = $data['estado'] ?? 'Pendiente';

        CartaLog::create($data);

        return redirect()
            ->route('cartas_log.index')
            ->with('success', 'Carta registrada correctamente.');
    }

    /**
     * Actualizar carta
     */
    public function update(Request $request, $id)
    {
        $carta = CartaLog::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'required|unique:cartas_log,codigo,' . $carta->id,
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
        ]);

        $carta->update($data);

        return redirect()
            ->route('cartas_log.index')
            ->with('success', 'Carta actualizada correctamente.');
    }

    /**
     * Eliminar carta
     */
    public function destroy($id)
    {
        CartaLog::findOrFail($id)->delete();

        return redirect()
            ->route('cartas_log.index')
            ->with('success', 'Carta eliminada correctamente.');
    }

    /**
     * Exportar Excel (backup)
     */
    public function exportExcel(Request $request)
    {
        $buscar = $request->get('buscar');

        return Excel::download(
            new CartasLogExport($buscar),
            'backup_cartas_log_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdfIndividual($id)
    {
        $carta = CartaLog::findOrFail($id);

        $pdf = Pdf::loadView('cartas_log.pdf_individual', compact('carta'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Carta_SO_LOG_' . $carta->codigo . '.pdf');
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Rechazado,Ejecutado'
        ]);

        $carta = CartaLog::findOrFail($id);
        $carta->estado = $request->estado;
        $carta->save();

        return back();
    }

    /**
     * Historial de auditoría de una carta (quién creó/modificó/qué cambió).
     */
    public function historial($id)
    {
        $carta = CartaLog::findOrFail($id);

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
}
