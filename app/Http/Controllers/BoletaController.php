<?php

namespace App\Http\Controllers;

use App\Models\Boleta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BoletaController extends Controller
{
    public function index(Request $request)
    {
        $puedeGestionar = Auth::user()->puedeGestionarBoletas();

        if ($puedeGestionar) {
            $query = Boleta::with('trabajador')->orderByDesc('id');

            if ($request->filled('trabajador')) {
                $query->where('user_id', $request->trabajador);
            }

            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            $boletas = $query->get();
            $trabajadores = User::orderBy('name')->get(['id', 'name', 'cargo']);
        } else {
            $query = Boleta::where('user_id', Auth::id())->orderByDesc('id');

            if ($request->filled('tipo')) {
                $query->where('tipo', $request->tipo);
            }

            $boletas = $query->get();
            $trabajadores = collect();
        }

        // Boletas propias del usuario logueado que todavía no confirmó que
        // le pertenecen (aplica a cualquier rol: RRHH y admin también cobran).
        $boletasPendientesConfirmar = Boleta::where('user_id', Auth::id())
            ->whereNull('confirmado_en')
            ->orderByDesc('id')
            ->get();

        return view('boletas.index', compact('boletas', 'trabajadores', 'puedeGestionar', 'boletasPendientesConfirmar'));
    }

    /**
     * El propio trabajador confirma que una boleta subida le pertenece.
     * Solo el dueño de la boleta puede confirmarla.
     */
    public function confirmar(Boleta $boleta)
    {
        abort_if($boleta->user_id !== Auth::id(), 403, 'Esta boleta no te pertenece.');

        if (!$boleta->confirmado_en) {
            $boleta->confirmado_en = now();
            $boleta->save();
        }

        return back()->with('success', 'Confirmaste que esta boleta te pertenece.');
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user()->puedeGestionarBoletas(), 403, 'No tienes permiso para subir boletas.');

        $tipo = $request->input('tipo');
        $mesesPorTipo = [
            'cts' => ['05', '11'],
            'gratificacion' => ['07', '12'],
        ];

        $rules = [
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required|in:mensual,cts,gratificacion',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360',
        ];

        if ($tipo === 'mensual') {
            $rules['periodo'] = 'required|date_format:Y-m';
        } else {
            $rules['anio'] = 'required|digits:4';
            $rules['mes_fijo'] = 'required|in:'.implode(',', $mesesPorTipo[$tipo] ?? []);
        }

        $data = $request->validate($rules);

        $periodo = $tipo === 'mensual'
            ? $data['periodo']
            : $data['anio'].'-'.$data['mes_fijo'];

        $ruta = $request->file('archivo')->store('boletas', 'public');

        Boleta::create([
            'user_id' => $data['user_id'],
            'tipo' => $tipo,
            'periodo' => $periodo,
            'archivo' => $ruta,
            'subido_por' => Auth::user()->name,
        ]);

        return redirect()->route('boletas.index')->with('success', 'Boleta subida correctamente.');
    }

    public function destroy(Boleta $boleta)
    {
        abort_if(!Auth::user()->puedeGestionarBoletas(), 403, 'No tienes permiso para eliminar boletas.');

        if ($boleta->archivo && Storage::disk('public')->exists($boleta->archivo)) {
            Storage::disk('public')->delete($boleta->archivo);
        }

        $boleta->delete();

        return redirect()->route('boletas.index')->with('success', 'Boleta eliminada correctamente.');
    }
}
