<?php

namespace App\Http\Controllers;

use App\Traits\OptimizaFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    use OptimizaFoto;

    public function edit()
    {
        return view('perfil.edit', ['usuario' => Auth::user()]);
    }

    /**
     * Actualiza solo los datos personales del propio usuario (dirección,
     * cumpleaños, foto). Puesto (cargo) y fecha de ingreso son datos
     * administrativos y no se pueden editar desde aquí.
     */
    public function update(Request $request)
    {
        $request->validate([
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:15360',
        ]);

        $user = Auth::user();

        $user->direccion = $request->direccion;
        $user->fecha_nacimiento = $request->fecha_nacimiento;

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil && Storage::disk('public')->exists($user->foto_perfil)) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $user->foto_perfil = $this->guardarFotoOptimizada($request->file('foto_perfil'), 'perfiles');
        }

        $user->save();

        return back()->with('success', 'Tu perfil se actualizó correctamente.');
    }
}
