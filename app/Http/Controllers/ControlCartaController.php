<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\ControlCarta;
use App\Exports\ControlCartasExport;
use Maatwebsite\Excel\Facades\Excel;

class ControlCartaController extends Controller
{
    /**
     * Listado + buscador
     */
    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar'));

        $cartas = ControlCarta::query()
            ->when($buscar, function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('codigo', 'like', "%$buscar%")
                      ->orWhere('mes', 'like', "%$buscar%")
                      ->orWhere('servicio_compra', 'like', "%$buscar%")
                      ->orWhere('descripcion', 'like', "%$buscar%")
                      ->orWhere('proveedor_elegido', 'like', "%$buscar%")
                      ->orWhere('nro_orden', 'like', "%$buscar%")
                      ->orWhere('autorizado_por', 'like', "%$buscar%")
                      ->orWhere('area', 'like', "%$buscar%");
                });
            })
            ->orderBy('fecha', 'desc')
            ->paginate(10)
            ->appends(['buscar' => $buscar]);

        return view('control_cartas.index', compact('cartas', 'buscar'));
    }

    /**
     * Guardar carta
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:control_cartas,codigo',
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
        ]);

        ControlCarta::create($request->all());

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta registrada correctamente.');
    }

    /**
     * Actualizar carta
     */
    public function update(Request $request, $id)
    {
        $carta = ControlCarta::findOrFail($id);

        $request->validate([
            'codigo' => 'required|unique:control_cartas,codigo,' . $carta->id,
            'fecha' => 'required|date',
            'servicio_compra' => 'required|string',
        ]);

        $carta->update($request->all());

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta actualizada correctamente.');
    }

    /**
     * Eliminar carta
     */
    public function destroy($id)
    {
        ControlCarta::findOrFail($id)->delete();

        return redirect()
            ->route('control_cartas.index')
            ->with('success', 'Carta eliminada correctamente.');
    }

    /**
     * Exportar Excel (backup)
     */
    public function exportExcel(Request $request)
    {
        $buscar = $request->get('buscar');

        return Excel::download(
            new ControlCartasExport($buscar),
            'backup_cartas_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    public function exportPdfIndividual($id)
{
    $carta = ControlCarta::findOrFail($id);

    $pdf = Pdf::loadView('control_cartas.pdf_individual', compact('carta'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('Carta_SO_PRO_' . $carta->codigo . '.pdf');
}
}
