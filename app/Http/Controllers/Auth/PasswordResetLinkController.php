<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CodigoRecuperacionMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PasswordResetLinkController extends Controller
{
    const MINUTOS_VALIDEZ = 15;

    /**
     * Display the password reset request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Genera un código de 6 dígitos y lo envía al correo de recuperación
     * personal del usuario (no a su correo institucional de login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'No encontramos una cuenta con ese correo institucional.']);
        }

        if (!$user->correo_recuperacion) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Tu cuenta no tiene un correo de recuperación configurado. Contacta a un administrador para que te ayude a restablecer tu contraseña.']);
        }

        $codigo = (string) random_int(100000, 999999);

        PasswordResetCode::where('user_id', $user->id)->whereNull('usado_en')->delete();

        PasswordResetCode::create([
            'user_id' => $user->id,
            'codigo' => bcrypt($codigo),
            'expira_en' => now()->addMinutes(self::MINUTOS_VALIDEZ),
        ]);

        Mail::to($user->correo_recuperacion)->send(
            new CodigoRecuperacionMail($user, $codigo, self::MINUTOS_VALIDEZ)
        );

        return redirect()->route('password.reset', ['email' => $user->email])
            ->with('status', 'Enviamos un código a ' . $this->enmascarar($user->correo_recuperacion) . '. Ingrésalo junto con tu nueva contraseña.');
    }

    private function enmascarar(string $correo): string
    {
        [$usuario, $dominio] = array_pad(explode('@', $correo), 2, '');

        if (strlen($usuario) <= 2) {
            return $usuario[0] . '***@' . $dominio;
        }

        return substr($usuario, 0, 2) . str_repeat('*', max(strlen($usuario) - 2, 3)) . '@' . $dominio;
    }
}
