<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestringirAccesoPorRol
{
    /**
     * Nombres de ruta (admiten comodín *) permitidos para roles con acceso
     * limitado a Mantenimiento (mecánico y supervisor de mantenimiento).
     * Todo lo demás dentro del área autenticada queda bloqueado para ellos.
     */
    protected array $permitidasParaMantenimiento = [
        'dashboard',
        'reportes.*',
        'anomalias.*',
        'bienvenida',
        'logout',
        'firma.*',
    ];

    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->tieneAccesoLimitadoAMantenimiento()) {
            $routeName = $request->route()?->getName();

            $permitido = $routeName && collect($this->permitidasParaMantenimiento)
                ->contains(fn ($patron) => Str::is($patron, $routeName));

            if (!$permitido) {
                return redirect()->route('dashboard')
                    ->with('error', 'No tienes permiso para acceder a esa sección. Tu usuario solo tiene acceso a Mantenimiento.');
            }
        }

        return $next($request);
    }
}
