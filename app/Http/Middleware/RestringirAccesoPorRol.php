<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestringirAccesoPorRol
{
    /**
     * Nombres de ruta (admiten comodín *) permitidos para el rol "mecanico".
     * Todo lo demás dentro del área autenticada queda bloqueado para ese rol.
     */
    protected array $permitidasParaMecanico = [
        'dashboard',
        'reportes.*',
        'bienvenida',
        'logout',
    ];

    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->esSoloMantenimiento()) {
            $routeName = $request->route()?->getName();

            $permitido = $routeName && collect($this->permitidasParaMecanico)
                ->contains(fn ($patron) => Str::is($patron, $routeName));

            if (!$permitido) {
                return redirect()->route('dashboard')
                    ->with('error', 'No tienes permiso para acceder a esa sección. Tu usuario solo tiene acceso a Mantenimiento.');
            }
        }

        return $next($request);
    }
}
