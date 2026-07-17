<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FirmaSupervisorController extends Controller
{
    /**
     * Guarda/actualiza la firma dibujada y la clave de firma del supervisor
     * de mantenimiento. Se configura una sola vez y se reutiliza en cada reporte.
     */
    public function guardar(Request $request)
    {
        abort_if(!Auth::user()->esSupervisorMantenimiento(), 403, 'Solo el supervisor de mantenimiento puede configurar una firma.');

        $request->validate([
            'firma_data' => 'required|string',
            'pin' => 'required|string|min:4|confirmed',
        ]);

        $data = $request->firma_data;

        if (!preg_match('/^data:image\/(\w+);base64,/', $data)) {
            return back()->withErrors(['firma_data' => 'Firma inválida.']);
        }

        $data = substr($data, strpos($data, ',') + 1);
        $data = base64_decode($data);

        if ($data === false) {
            return back()->withErrors(['firma_data' => 'Firma inválida.']);
        }

        $user = Auth::user();

        if ($user->firma_imagen && Storage::disk('public')->exists($user->firma_imagen)) {
            Storage::disk('public')->delete($user->firma_imagen);
        }

        $rutaFirma = 'firmas_supervisores/firma_' . $user->id . '_' . time() . '.png';
        Storage::disk('public')->put($rutaFirma, $data);

        $user->firma_imagen = $rutaFirma;
        $user->firma_pin = Hash::make($request->pin);
        $user->save();

        return back()->with('success', 'Tu firma quedó configurada correctamente.');
    }
}
