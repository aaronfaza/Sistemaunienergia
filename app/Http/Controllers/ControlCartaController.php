<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlCarta;
use App\Exports\ControlCartasExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ControlCartaController extends Controller
{
   
    public function index(Request $request)
{
    $buscar = trim($request->get('buscar')); // limpiar espacios

    $cartas = \App\Models\ControlCarta::query()
        ->when($buscar, function ($query, $buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo', 'LIKE', "%{$buscar}%")
                  ->orWhere('mes', 'LIKE', "%{$buscar}%")
                  ->orWhere('servicio_compra', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%")
                  ->orWhere('proveedor_elegido', 'LIKE', "%{$buscar}%")
                  ->orWhere('nro_orden', 'LIKE', "%{$buscar}%")
                  ->orWhere('autorizado_por', 'LIKE', "%{$buscar}%")
                  ->orWhere('area', 'LIKE', "%{$buscar}%");
            });
        })
        ->orderBy('fecha', 'desc')
        ->paginate(10)
        ->appends(['buscar' => $buscar]); // mantiene el texto al cambiar de página

    return view('control_cartas.index', compact('cartas', 'buscar'));
}

    public function create()
    {
        return view('control_cartas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'fecha' => 'required|date',
            'mes' => 'required',
            'servicio_compra' => 'required',
            'descripcion' => 'required',
            'proveedor_elegido' => 'required',
            'cotizaciones_consideradas' => 'nullable',
            'equipo' => 'nullable',
            'especificacion' => 'nullable',
            'monto_soles' => 'nullable|numeric',
            'monto_dolares' => 'nullable|numeric',
            'n_orden' => 'nullable',
            'autorizado_por' => 'nullable',
            'factura_n' => 'nullable',
            'fecha_recepcion' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'fecha_pago' => 'nullable|date',
        ]);

        ControlCarta::create($request->all());

        return redirect()->route('control_cartas.index')->with('success', 'Carta registrada correctamente.');
    }

    public function exportExcel()
    {
        return Excel::download(new ControlCartasExport, 'control_cartas.xlsx');
    }

    public function exportPdf()
    {
        $cartas = ControlCarta::all();
        $pdf = PDF::loadView('control_cartas.pdf', compact('cartas'));
        return $pdf->download('control_cartas.pdf');
    }
    public function destroy($id)
        {
            // Buscar el registro por ID
            $controlCarta = ControlCarta::findOrFail($id);

            // Eliminarlo
            $controlCarta->delete();

            // Redirigir con mensaje de éxito
            return redirect()->route('control_cartas.index')
                            ->with('success', 'Carta eliminada correctamente.');
        }

        public function update(Request $request, $id)
{
    $request->validate([
        'codigo' => 'required|string|max:255',
        'fecha' => 'required|date',
        'mes' => 'nullable|string|max:50',
        'servicio_compra' => 'required|string|max:500',
        'descripcion' => 'nullable|string',
        'proveedor_elegido' => 'nullable|string|max:255',
        'cotizaciones_consideradas' => 'nullable|string',
        'equipo' => 'nullable|string|max:255',
        'especificacion' => 'nullable|string|max:500',
        'monto_soles' => 'nullable|numeric',
        'monto_dolares' => 'nullable|numeric',
        'nro_orden' => 'nullable|string|max:100',
        'autorizado_por' => 'nullable|string|max:255',
        'factura_nro' => 'nullable|string|max:100',
        'fecha_recepcion' => 'nullable|date',
        'fecha_vencimiento' => 'nullable|date',
        'fecha_pago' => 'nullable|date',
        'area' => 'nullable|string|max:255',
    ]);

    $carta = \App\Models\ControlCarta::findOrFail($id);

    $carta->update($request->only([
        'codigo',
        'fecha',
        'mes',
        'servicio_compra',
        'descripcion',
        'proveedor_elegido',
        'cotizaciones_consideradas',
        'equipo',
        'especificacion',
        'monto_soles',
        'monto_dolares',
        'nro_orden',
        'autorizado_por',
        'factura_nro',
        'fecha_recepcion',
        'fecha_vencimiento',
        'fecha_pago',
        'area',
    ]));

    return redirect()->route('control_cartas.index')->with('success', 'Carta actualizada correctamente.');
}


}
