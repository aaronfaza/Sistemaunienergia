<?php

namespace App\Http\Controllers;

use App\Models\CartaFis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartaFisController extends Controller
{
    public function index(Request $request)
    {
        $query = CartaFis::query();

        // Buscador simple
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('codigo', 'like', "%{$buscar}%")
                  ->orWhere('servicio_compra', 'like', "%{$buscar}%")
                  ->orWhere('proveedor_elegido', 'like', "%{$buscar}%")
                  ->orWhere('area', 'like', "%{$buscar}%");
            });
        }

        // Paginación (cámbialo a 10/15 si quieres)
        $cartas = $query->orderByDesc('id')->paginate(10)->withQueryString();

        return view('cartas_fis.index', compact('cartas'));
    }

    public function store(Request $request)
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
        ]);

        $data['created_by'] = Auth::id();

        CartaFis::create($data);

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS registrada correctamente.');
    }

    public function update(Request $request, $id)
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
        ]);

        $data['updated_by'] = Auth::id();

        $carta->update($data);

        if ($request->has('estado') && $request->keys() === ['_token','_method','estado']) {
        $carta->update([
            'estado' => $request->estado,
            'updated_by' => Auth::id(),
        ]);
        return back()->with('success', 'Estado actualizado');
    }

    // update normal
    $carta->update(array_merge(
        $request->all(),
        ['updated_by' => Auth::id()]
    ));

    return back()->with('success', 'Carta actualizada');

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS actualizada correctamente.');
    }

    public function destroy($id)
    {
        $carta = CartaFis::findOrFail($id);
        $carta->delete();

        return redirect()->route('cartas_fis.index')->with('success', 'Carta FIS eliminada.');
    }
}
