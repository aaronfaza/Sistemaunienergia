<?php

namespace App\Http\Controllers;

use App\Models\Requerimiento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardWelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Fechas base
        $hoy       = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes    = Carbon::now()->endOfMonth();

        // ===== KPIs =====
        $totalMes = Requerimiento::whereBetween('created_at', [$inicioMes, $finMes])->count();

        $hoyCount = Requerimiento::whereDate('created_at', $hoy)->count();

        $kpi = [
            'total_mes'  => $totalMes,
            'hoy'        => $hoyCount,
        ];

        // Top área del mes
        $topArea = Requerimiento::select('area_solicitante', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->groupBy('area_solicitante')
            ->orderByDesc('total')
            ->first();

        // Actividad reciente (últimos 8)
        $actividad = Requerimiento::select('id', 'codigo', 'area_solicitante', 'nombre_solicitante', 'created_at')
            ->latest('created_at')
            ->limit(8)
            ->get();

        // Barras por área (mes)
        $porArea = Requerimiento::select('area_solicitante as area', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->groupBy('area')
            ->orderByDesc('total')
            ->get();

        // Línea: últimos 30 días (rellena días sin datos con 0)
        $desde = Carbon::now()->subDays(29)->startOfDay();
        $raw = Requerimiento::where('created_at', '>=', $desde)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as dia'), DB::raw('COUNT(*) as total'))
            ->pluck('total', 'dia'); // ['2025-02-01' => 3, ...]

        $porDia = collect();
        for ($d = $desde->copy(); $d->lte(Carbon::today()); $d->addDay()) {
            $key = $d->toDateString();
            $porDia->push((object)[
                'dia'   => $key,
                'total' => (int) ($raw[$key] ?? 0),
            ]);
        }

        // Calendario: usa columna 'fecha' si existe; si no, cae a created_at
        // Trae un rango ampliado para que el mes actual se vea completo
        $rangoInicio = Carbon::now()->startOfMonth()->subWeeks(1);
        $rangoFin    = Carbon::now()->endOfMonth()->addWeeks(1);

        $eventoQuery = Requerimiento::query()
            ->select('id', 'codigo', 'area_solicitante as area', 'servicio', 'fecha', 'created_at');

        // Si la columna 'fecha' no existe o está siempre null, usa created_at
        // (no rompe si 'fecha' sí existe)
        $eventos = $eventoQuery
            ->where(function ($q) use ($rangoInicio, $rangoFin) {
                $q->whereBetween('fecha', [$rangoInicio, $rangoFin])
                  ->orWhereBetween('created_at', [$rangoInicio, $rangoFin]);
            })
            ->get()
            ->map(function ($r) {
                $start = $r->fecha ?: $r->created_at;
                return [
                    'id'     => $r->id,
                    'codigo' => $r->codigo,
                    'area'   => $r->area,
                    'servicio' => $r->servicio,
                    'start'  => Carbon::parse($start)->toDateString(),
                ];
            });

        // Notificaciones del dropdown (últimos 5)
        $notificaciones = Requerimiento::latest('created_at')->take(5)->get();

        // ===== Usuarios: activos, últimas conexiones y cumpleaños =====
        $usuariosActivos = User::where('last_login_at', '>=', Carbon::now()->subDays(30))->count();

        $ultimasConexiones = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->limit(8)
            ->get(['id', 'name', 'cargo', 'last_login_at']);

        $cumpleañosMes = User::whereNotNull('fecha_nacimiento')
            ->whereMonth('fecha_nacimiento', $hoy->month)
            ->get(['id', 'name', 'cargo', 'fecha_nacimiento'])
            ->sortBy(fn ($u) => $u->fecha_nacimiento->day)
            ->values();

        return view('bienvenida', compact(
            'kpi',
            'topArea',
            'actividad',
            'porArea',
            'porDia',
            'eventos',
            'notificaciones',
            'usuariosActivos',
            'ultimasConexiones',
            'cumpleañosMes'
        ));
    }
}
