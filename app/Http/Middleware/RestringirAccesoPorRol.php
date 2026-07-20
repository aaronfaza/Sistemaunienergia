<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RestringirAccesoPorRol
{
    /**
     * Nombres de ruta (admiten comodín *) permitidos por rol restringido.
     * El rol "admin" no pasa por esta lista: tiene acceso completo.
     * Cualquier rol que no esté aquí cae al valor por defecto (mínimo
     * acceso: bienvenida, perfil y logout), para no dejar una puerta
     * abierta por accidente si se agrega un rol nuevo más adelante.
     */
    protected array $permitidasPorRol = [
        'mecanico' => [
            'dashboard', 'reportes.*', 'anomalias.*', 'firma.*',
            'bienvenida', 'perfil.*', 'boletas.*', 'logout',
        ],
        'supervisor' => [
            'dashboard', 'reportes.*', 'anomalias.*', 'firma.*',
            'bienvenida', 'perfil.*', 'boletas.*', 'logout',
        ],
        'rrhh' => [
            'bienvenida', 'perfil.*', 'boletas.*', 'logout',
        ],
    ];

    protected array $permitidasPorDefecto = [
        'bienvenida', 'perfil.*', 'logout',
    ];

    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->tieneAccesoCompleto()) {
            $permitidas = $this->permitidasPorRol[$user->rol] ?? $this->permitidasPorDefecto;
            $routeName = $request->route()?->getName();

            $permitido = $routeName && collect($permitidas)
                ->contains(fn ($patron) => Str::is($patron, $routeName));

            if (!$permitido) {
                return redirect()->route('bienvenida')
                    ->with('error', 'No tienes permiso para acceder a esa sección.');
            }
        }

        return $next($request);
    }
}
