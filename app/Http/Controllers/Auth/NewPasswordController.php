<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Display the "enter code + new password" view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->query('email')]);
    }

    /**
     * Verifica el código de recuperación y actualiza la contraseña.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'codigo' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        $error = back()->withInput($request->only('email'))
            ->withErrors(['codigo' => 'El código ingresado no es válido o ya venció. Solicita uno nuevo.']);

        if (!$user) {
            return $error;
        }

        $registro = PasswordResetCode::where('user_id', $user->id)
            ->whereNull('usado_en')
            ->latest('id')
            ->first();

        if (!$registro || !$registro->estaVigente() || !Hash::check($request->codigo, $registro->codigo)) {
            return $error;
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        $registro->update(['usado_en' => now()]);

        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Tu contraseña se actualizó correctamente. Ya puedes iniciar sesión.');
    }
}
