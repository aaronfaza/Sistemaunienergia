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

            $boletas = $query->get();
            $trabajadores = User::orderBy('name')->get(['id', 'name', 'cargo']);
        } else {
            $boletas = Boleta::where('user_id', Auth::id())->orderByDesc('id')->get();
            $trabajadores = collect();
        }

        return view('boletas.index', compact('boletas', 'trabajadores', 'puedeGestionar'));
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user()->puedeGestionarBoletas(), 403, 'No tienes permiso para subir boletas.');

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periodo' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360',
        ]);

        $ruta = $request->file('archivo')->store('boletas', 'public');

        Boleta::create([
            'user_id' => $request->user_id,
            'periodo' => $request->periodo,
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
