<?php

namespace App\Http\Controllers;

use App\Models\Requerimiento;
use App\Models\ReporteMantenimiento;
use App\Models\Anomalia;
use App\Models\Boleta;
use App\Models\LogisticaLote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardWelcomeController extends Controller
{
    public function index(Request $request)
    {
        $hoy       = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();
        $finMes    = Carbon::now()->endOfMonth();

        // Cada rol ve la "Bienvenida" adaptada a su propio caso de uso:
        // mecánico/supervisor -> Mantenimiento y Anomalías; RRHH -> Boletas;
        // admin -> Requerimientos; una cuenta autoregistrada sin rol asignado
        // no ve datos de negocio de ningún módulo.
        $vistaMantenimiento = Auth::user()->tieneAccesoLimitadoAMantenimiento();
        $vistaRRHH = Auth::user()->esRRHH();
        $vistaLogistica = Auth::user()->esLogistica();
        $vistaPendiente = Auth::user()->esCuentaPendiente();
        $logisticaStats = null;

        if ($vistaMantenimiento) {
            [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones] =
                $this->datosMantenimiento($hoy, $inicioMes, $finMes);
        } elseif ($vistaRRHH) {
            [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones] =
                $this->datosRRHH($hoy, $inicioMes, $finMes);
        } elseif ($vistaLogistica) {
            [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones, $logisticaStats] =
                $this->datosLogistica();
        } elseif ($vistaPendiente) {
            [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones] =
                $this->datosPendiente();
        } else {
            [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones] =
                $this->datosRequerimientos($hoy, $inicioMes, $finMes);
        }

        // ===== Usuarios: activos, últimas conexiones y cumpleaños =====
        // (esto es igual para todos: es la parte "social" del panel)
        $usuariosActivos = User::where('last_login_at', '>=', Carbon::now()->subDays(30))->count();

        // Logística ya tiene 4 KPIs propios (Total/% Ejecutados/% Pendientes/
        // % Vencidos); agregar este 5º card fuerza scroll horizontal en la fila.
        if (!$vistaLogistica) {
            $kpiCards[] = [
                'icono' => 'fa-user-check',
                'color' => 'is-success',
                'valor' => $usuariosActivos,
                'label' => 'Usuarios activos (30 días)',
            ];
        }

        $ultimasConexiones = User::whereNotNull('last_login_at')
            ->orderByDesc('last_login_at')
            ->limit(8)
            ->get(['id', 'name', 'cargo', 'last_login_at', 'foto_perfil']);

        $cumpleañosMes = User::whereNotNull('fecha_nacimiento')
            ->whereMonth('fecha_nacimiento', $hoy->month)
            ->get(['id', 'name', 'cargo', 'fecha_nacimiento', 'foto_perfil'])
            ->sortBy(fn ($u) => $u->fecha_nacimiento->day)
            ->values();

        return view('bienvenida', compact(
            'kpiCards',
            'actividad',
            'porArea',
            'porDia',
            'eventos',
            'notificaciones',
            'usuariosActivos',
            'ultimasConexiones',
            'cumpleañosMes',
            'vistaMantenimiento',
            'vistaRRHH',
            'vistaLogistica',
            'vistaPendiente',
            'logisticaStats'
        ));
    }

    /**
     * Datos para una cuenta autoregistrada que todavía no tiene rol asignado:
     * no debe ver ningún dato de negocio, solo un aviso de que su cuenta
     * está a la espera de que un administrador le asigne un rol.
     */
    private function datosPendiente(): array
    {
        $kpiCards = [];
        $actividad = collect();
        $porArea = collect();
        $porDia = collect();
        $eventos = collect();
        $notificaciones = collect();

        return [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones];
    }

    /**
     * Datos para el rol "administración": todo gira alrededor de Requerimientos.
     */
    private function datosRequerimientos($hoy, $inicioMes, $finMes): array
    {
        $totalMes = Requerimiento::whereBetween('created_at', [$inicioMes, $finMes])->count();
        $hoyCount = Requerimiento::whereDate('created_at', $hoy)->count();

        $topArea = Requerimiento::select('area_solicitante', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->groupBy('area_solicitante')
            ->orderByDesc('total')
            ->first();

        $kpiCards = [
            ['icono' => 'fa-calendar-alt', 'color' => 'is-primary', 'valor' => $totalMes, 'label' => 'Requerimientos (mes)'],
            ['icono' => 'fa-clock', 'color' => 'is-info', 'valor' => $hoyCount, 'label' => 'Hoy'],
            ['icono' => 'fa-building', 'color' => 'is-primary', 'valor' => $topArea->area_solicitante ?? '—', 'label' => 'Top área (mes)'],
        ];

        $nombresUsuarios = $this->mapaFotosPorNombre();

        $actividad = Requerimiento::select('id', 'codigo', 'area_solicitante', 'nombre_solicitante', 'created_at')
            ->latest('created_at')
            ->limit(8)
            ->get()
            ->map(fn ($r) => $this->itemFeed(
                'fa-file-alt',
                'primary',
                $r->nombre_solicitante,
                $nombresUsuarios[$r->nombre_solicitante] ?? null,
                'registró un requerimiento',
                $r->codigo . ' · ' . $r->area_solicitante,
                $r->created_at,
                route('requerimientos.imprimir', $r->id)
            ));

        $porArea = Requerimiento::select('area_solicitante as area', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->groupBy('area')
            ->orderByDesc('total')
            ->get();

        $porDia = $this->serieDiaria(Requerimiento::class);

        $rangoInicio = Carbon::now()->startOfMonth()->subWeeks(1);
        $rangoFin    = Carbon::now()->endOfMonth()->addWeeks(1);

        $eventos = Requerimiento::query()
            ->select('id', 'codigo', 'area_solicitante as area', 'servicio', 'fecha', 'created_at')
            ->where(function ($q) use ($rangoInicio, $rangoFin) {
                $q->whereBetween('fecha', [$rangoInicio, $rangoFin])
                  ->orWhereBetween('created_at', [$rangoInicio, $rangoFin]);
            })
            ->get()
            ->map(function ($r) {
                $start = $r->fecha ?: $r->created_at;
                return [
                    'id'      => $r->id,
                    'titulo'  => "{$r->codigo} • {$r->area} • {$r->servicio}",
                    'start'   => Carbon::parse($start)->toDateString(),
                    'url'     => route('requerimientos.imprimir', $r->id),
                ];
            });

        $notificaciones = Requerimiento::latest('created_at')->take(5)->get();

        return [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones];
    }

    /**
     * Datos para mecánico/supervisor de mantenimiento: Mantenimiento + Anomalías,
     * sin nada de Requerimientos ni Logística.
     */
    private function datosMantenimiento($hoy, $inicioMes, $finMes): array
    {
        $totalMes   = ReporteMantenimiento::whereBetween('created_at', [$inicioMes, $finMes])->count();
        $hoyCount   = ReporteMantenimiento::whereDate('created_at', $hoy)->count();
        $pendientes = Anomalia::where('estado', 'Pendiente')->count();

        $kpiCards = [
            ['icono' => 'fa-tools', 'color' => 'is-primary', 'valor' => $totalMes, 'label' => 'Reportes de mantenimiento (mes)'],
            ['icono' => 'fa-clock', 'color' => 'is-info', 'valor' => $hoyCount, 'label' => 'Reportes hoy'],
            ['icono' => 'fa-exclamation-triangle', 'color' => 'is-danger', 'valor' => $pendientes, 'label' => 'Anomalías pendientes'],
        ];

        $nombresUsuarios = $this->mapaFotosPorNombre();

        $reportesFeed = ReporteMantenimiento::select('id', 'nombre', 'tipo_equipo', 'ubicacion', 'created_at')
            ->latest('created_at')->limit(6)->get()
            ->map(fn ($r) => $this->itemFeed(
                'fa-tools',
                'primary',
                $r->nombre,
                $nombresUsuarios[$r->nombre] ?? null,
                'registró un reporte de mantenimiento',
                "{$r->tipo_equipo} · {$r->ubicacion}",
                $r->created_at,
                route('reportes.show', $r->id)
            ));

        $anomaliasFeed = Anomalia::select('id', 'nombre', 'pozo', 'tipo_equipo', 'gravedad', 'estado', 'created_at')
            ->latest('created_at')->limit(6)->get()
            ->map(fn ($a) => $this->itemFeed(
                'fa-exclamation-triangle',
                $a->estado === 'Pendiente' ? 'danger' : 'success',
                $a->nombre,
                $nombresUsuarios[$a->nombre] ?? null,
                'reportó una anomalía (' . $a->gravedad . ')',
                "{$a->tipo_equipo} · Pozo {$a->pozo}",
                $a->created_at,
                route('anomalias.show', $a->id)
            ));

        $actividad = $reportesFeed->concat($anomaliasFeed)
            ->sortByDesc(fn ($item) => $item['created_at'])
            ->take(8)
            ->values();

        $porArea = ReporteMantenimiento::select('tipo_equipo as area', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$inicioMes, $finMes])
            ->groupBy('area')
            ->orderByDesc('total')
            ->get();

        $porDia = $this->serieDiaria(ReporteMantenimiento::class);

        $eventos = ReporteMantenimiento::select('id', 'titulo', 'tipo_equipo', 'ubicacion', 'fecha_inicio')
            ->whereNotNull('fecha_inicio')
            ->get()
            ->map(fn ($r) => [
                'id'     => $r->id,
                'titulo' => trim(($r->titulo ?: 'Mantenimiento') . " • {$r->tipo_equipo} • {$r->ubicacion}"),
                'start'  => Carbon::parse($r->fecha_inicio)->toDateString(),
                'url'    => route('reportes.show', $r->id),
            ]);

        $notificaciones = Anomalia::latest('created_at')->take(5)->get();

        return [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones];
    }

    /**
     * Datos para RRHH: su único caso de uso es Boletas de pago.
     */
    private function datosRRHH($hoy, $inicioMes, $finMes): array
    {
        $totalBoletasMes = Boleta::whereBetween('created_at', [$inicioMes, $finMes])->count();
        $totalTrabajadores = User::count();
        $conBoletaEsteMes = Boleta::whereBetween('created_at', [$inicioMes, $finMes])
            ->distinct('user_id')
            ->count('user_id');
        $sinBoletaEsteMes = max($totalTrabajadores - $conBoletaEsteMes, 0);

        $kpiCards = [
            ['icono' => 'fa-file-invoice-dollar', 'color' => 'is-primary', 'valor' => $totalBoletasMes, 'label' => 'Boletas subidas (mes)'],
            ['icono' => 'fa-users', 'color' => 'is-info', 'valor' => $totalTrabajadores, 'label' => 'Trabajadores registrados'],
            ['icono' => 'fa-exclamation-triangle', 'color' => 'is-danger', 'valor' => $sinBoletaEsteMes, 'label' => 'Sin boleta este mes'],
        ];

        $nombresUsuarios = $this->mapaFotosPorNombre();

        $actividad = Boleta::with('trabajador')
            ->latest('created_at')->limit(8)->get()
            ->map(fn ($b) => $this->itemFeed(
                'fa-file-invoice-dollar',
                'primary',
                $b->subido_por ?? 'RRHH',
                $nombresUsuarios[$b->subido_por] ?? null,
                'subió la boleta de ' . ($b->trabajador->name ?? 'un trabajador'),
                'Periodo: ' . $b->periodo,
                $b->created_at,
                asset('storage/' . $b->archivo)
            ));

        $porArea = Boleta::whereBetween('created_at', [$inicioMes, $finMes])
            ->select('periodo as area', DB::raw('COUNT(*) as total'))
            ->groupBy('area')
            ->orderByDesc('total')
            ->get();

        $porDia = $this->serieDiaria(Boleta::class);

        $eventos = collect();

        $notificaciones = Boleta::latest('created_at')->take(5)->get();

        return [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones];
    }

    /**
     * Datos para Logística Lima (Miguel, Esmeralda, Yahaira): panel de
     * ROP2026 Lote IX. Los KPIs y las series de las gráficas vienen de
     * LogisticaLote::estadisticasGenerales(), la misma fuente que usa la
     * hoja "Dashboard" del backup Excel, para que ambos siempre coincidan.
     */
    private function datosLogistica(): array
    {
        $stats = LogisticaLote::estadisticasGenerales();

        $kpiCards = [
            ['icono' => 'fa-folder-open', 'color' => 'is-primary', 'valor' => $stats['total'], 'label' => 'Total expedientes'],
            ['icono' => 'fa-check-double', 'color' => 'is-success', 'valor' => $stats['pct_ejecutados'] . '%', 'label' => '% Ejecutados'],
            ['icono' => 'fa-hourglass-half', 'color' => 'is-info', 'valor' => $stats['pct_pendientes'] . '%', 'label' => '% Pendientes'],
            ['icono' => 'fa-exclamation-triangle', 'color' => 'is-danger', 'valor' => $stats['pct_vencidos'] . '%', 'label' => '% Vencidos/Observados'],
        ];

        $nombresUsuarios = $this->mapaFotosPorNombre();

        $actividad = LogisticaLote::with(['creador', 'modificador'])
            ->latest('updated_at')
            ->limit(8)
            ->get()
            ->map(function ($lote) use ($nombresUsuarios) {
                $nombre = $lote->modificador->name ?? $lote->creador->name ?? 'Sistema';

                return $this->itemFeed(
                    'fa-boxes',
                    'primary',
                    $nombre,
                    $nombresUsuarios[$nombre] ?? null,
                    'actualizó el expediente',
                    $lote->cod_log . ' · ' . $lote->estado,
                    $lote->updated_at,
                    route('logistica_lotes.index')
                );
            });

        $porArea = collect();
        $porDia = collect();
        $eventos = collect();
        $notificaciones = LogisticaLote::latest('created_at')->take(5)->get();

        return [$kpiCards, $actividad, $porArea, $porDia, $eventos, $notificaciones, $stats];
    }

    /**
     * Serie de los últimos 30 días (rellena los días sin datos con 0),
     * reutilizable para cualquier modelo que tenga created_at.
     */
    private function serieDiaria(string $modelo)
    {
        $desde = Carbon::now()->subDays(29)->startOfDay();

        $raw = $modelo::where('created_at', '>=', $desde)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'))
            ->select(DB::raw('DATE(created_at) as dia'), DB::raw('COUNT(*) as total'))
            ->pluck('total', 'dia');

        $porDia = collect();
        for ($d = $desde->copy(); $d->lte(Carbon::today()); $d->addDay()) {
            $key = $d->toDateString();
            $porDia->push((object) [
                'dia'   => $key,
                'total' => (int) ($raw[$key] ?? 0),
            ]);
        }

        return $porDia;
    }

    /**
     * Mapa "nombre de usuario" => foto de perfil, para poder mostrar el
     * avatar real en el feed de actividad cuando el nombre coincide.
     */
    private function mapaFotosPorNombre(): array
    {
        return User::pluck('foto_perfil', 'name')->toArray();
    }

    /**
     * Normaliza un evento del feed de actividad ("estilo red social"):
     * avatar/ícono + quién + qué hizo + detalle + hace cuánto.
     */
    private function itemFeed(string $icono, string $color, string $usuario, ?string $foto, string $accion, string $detalle, $creadoEn, ?string $url = null): array
    {
        return [
            'icono'      => $icono,
            'color'      => $color,
            'usuario'    => $usuario,
            'foto'       => $foto,
            'accion'     => $accion,
            'detalle'    => $detalle,
            'created_at' => Carbon::parse($creadoEn),
            'url'        => $url,
        ];
    }
}
