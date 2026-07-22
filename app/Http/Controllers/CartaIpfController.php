<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\CartaIpf;
use App\Exports\CartasIpfExport;
use Maatwebsite\Excel\Facades\Excel;

class CartaIpfController extends Controller
{
    /**
     * Listado + buscador
     */
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');
        $anio = in_array($request->get('anio'), ['2026', '2027'], true) ? $request->get('anio') : null;

        $cartas = CartaIpf::with(['creador', 'modificador', 'ropLote'])
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

        return view('cartas_ipf.index', compact('cartas', 'buscar', 'anio'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:cartas_ipf,codigo',
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

        CartaIpf::create($data);

        return redirect()
            ->route('cartas_ipf.index')
            ->with('success', 'Carta registrada correctamente.');
    }

    /**
     * Actualizar carta
     */
    public function update(Request $request, $id)
    {
        $carta = CartaIpf::findOrFail($id);

        $data = $request->validate([
            'codigo' => 'required|unique:cartas_ipf,codigo,' . $carta->id,
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
            ->route('cartas_ipf.index')
            ->with('success', 'Carta actualizada correctamente.');
    }

    /**
     * Eliminar carta
     */
    public function destroy($id)
    {
        CartaIpf::findOrFail($id)->delete();

        return redirect()
            ->route('cartas_ipf.index')
            ->with('success', 'Carta eliminada correctamente.');
    }

    /**
     * Exportar Excel (backup)
     */
    public function exportExcel(Request $request)
    {
        $buscar = $request->get('buscar');

        return Excel::download(
            new CartasIpfExport($buscar),
            'backup_cartas_ipf_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdfIndividual($id)
    {
        $carta = CartaIpf::findOrFail($id);

        $pdf = Pdf::loadView('cartas_ipf.pdf_individual', compact('carta'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('Carta_SO_IPF_' . $carta->codigo . '.pdf');
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Rechazado,Ejecutado'
        ]);

        $carta = CartaIpf::findOrFail($id);
        $carta->estado = $request->estado;
        $carta->save();

        return back();
    }

    /**
     * Historial de auditoría de una carta (quién creó/modificó/qué cambió).
     */
    public function historial($id)
    {
        $carta = CartaIpf::findOrFail($id);

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
