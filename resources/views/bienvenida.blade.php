<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISTEMA INTEGRADO DE GESTION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <!-- FullCalendar (CSS correcto v6) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">

  <!-- (Opcional) DataTables Bootstrap 4 si lo usaras aquí -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> -->

  <style>
    /* ===== Paleta corporativa (ajusta aquí) ===== */
    :root{
      --brand-primary: #003366;   /* azul corporativo */
      --brand-primary-dark: #002B5C;
      --brand-accent: #00A86B;    /* verde acento */
      --brand-accent-dark: #038b5a;
      --brand-info: #17a2b8;      /* info */
      --brand-danger: #dc3545;    /* danger */
      --sidebar-bg: #121212;      /* fondo cabecera sidebar */
      --sidebar-main: #1F1F1F;    /* fondo cuerpo sidebar */
      --text-on-brand: #ffffff;

      /* Alturas para layout sticky */
      --header-h: 56px;  /* ajusta si tu navbar es más alto */
      --footer-h: 44px;  /* pon 0 si no quieres footer fijo */
    }

    /* ========== LAYOUT: navbar/sidebar fijos y scroll SOLO en el contenido ========== */
    html, body{
      height: 100%;
      overflow: hidden; /* bloquea scroll global */
    }
    .wrapper{ height: 100vh; overflow: hidden; }

    /* Navbar */
    .navbar-uni { background-color: var(--brand-primary); box-shadow: 0 2px 4px rgba(0,0,0,.2); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand { color: var(--text-on-brand); }
    .navbar-uni .nav-link:hover { opacity: .9; }
    .main-header{ position: sticky; top: 0; z-index: 1035; height: var(--header-h); }

    /* Sidebar */
    .main-sidebar { background-color: var(--sidebar-main) !important; }
    .brand-area { background-color: var(--sidebar-bg); }
    .brand-area .brand-text { color: var(--text-on-brand); }
    .nav-sidebar .nav-link { color: #eaeaea !important; border-radius: .35rem; margin: 0 .25rem; }
    .nav-sidebar .nav-link.active {
      background: linear-gradient(90deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color: #fff !important;
    }
    .nav-sidebar .nav-link:hover { background-color: rgba(255,255,255,.08) !important; color: #fff !important; }
    .nav-icon.text-info { color: var(--brand-info) !important; }
    .nav-icon.text-success { color: var(--brand-accent) !important; }

    /* Contenido: ÚNICO que scrollea */
    .content-wrapper{
      background-color:#f8f9fa;
      height: calc(100vh - var(--header-h) - var(--footer-h));
      overflow: auto;
      -webkit-overflow-scrolling: touch;
    }

    /* Footer fijo abajo (quítalo si no lo quieres fijo) */
    .main-footer{
      position: sticky; bottom: 0; z-index: 1020; background:#fff;
    }

    @media (min-width: 992px){
      :root{ --header-h: 64px; } /* header un poco más alto en desktop */
    }

    /* Tipografía de títulos */
    .heading-font { font-family: 'Montserrat', sans-serif; }

    /* Cards limpias */
    .card-clean { border: 1px solid rgba(0,0,0,.06); box-shadow: 0 2px 10px rgba(0,0,0,.04); }

    /* ===== KPI Cards ===== */
    .dashboard-safe-container{ padding-left:clamp(16px,4vw,36px); padding-right:clamp(16px,4vw,36px); }
    .stat-row{ margin-left:-8px; margin-right:-8px; }
    .stat-row > [class*="col-"]{ padding-left:8px; padding-right:8px; }
    @media (min-width: 992px){ .stat-row-lg-nowrap{ flex-wrap:nowrap!important; } }

    .stat-card{
      display:flex; align-items:center; gap:14px;
      padding:14px 16px; border-radius:14px; min-height:96px;
      background:linear-gradient(180deg,#fff,#fbfcff);
      border:1px solid #eef2f7; box-shadow:0 6px 16px rgba(20,30,58,0.1);
      transition:transform .2s ease, box-shadow .2s ease;
    }
    .stat-card:hover{ transform:translateY(-2px); box-shadow:0 12px 28px rgba(20,30,58,0.12); }
    .stat-icon{ width:48px; height:48px; border-radius:12px; display:grid; place-items:center; background:#eef4ff; }
    .stat-icon i{ font-size:20px; }
    .is-primary .stat-icon{ background:rgba(13,110,253,.12); color:#0d6efd; }
    .is-info .stat-icon{ background:rgba(43,183,246,.12); color:#2bb7f6; }
    .is-success .stat-icon{ background:rgba(24,181,143,.12); color:#18b58f; }
    .stat-meta{ display:flex; flex-direction:column; color:#25334a; }
    .stat-kpi span{ font-weight:700; font-size:clamp(20px,3.5vw,28px); letter-spacing:-.5px; line-height:1; }
    .stat-label{ font-size:.85rem; opacity:.8; }
  </style>
</head>

<!-- body fijo para que solo scrollee el content -->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

 <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-uni">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Abrir menú">
            <i class="fas fa-bars fa-lg"></i>
          </a>
        </li>
        <li class="nav-item d-flex align-items-center ml-2">
          <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width:25px;height:25px;">
        </li>
      </ul>

      <!-- Notificaciones + Perfil -->
      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <!-- Notificaciones -->
        <li class="nav-item dropdown mr-3">
          <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell fa-lg text-white"></i>
            @if(isset($notificaciones) && $notificaciones->count() > 0)
              <span id="notiBadge" class="badge badge-danger position-absolute" style="top:-4px;right:-8px;font-size:.65rem;">
                {{ $notificaciones->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificacionesDropdown" style="min-width:300px;max-height:400px;overflow-y:auto;">
            <h6 class="dropdown-header font-weight-bold text-dark">🔔 Últimos registros</h6>
            <div class="dropdown-divider"></div>
            @forelse(($notificaciones ?? collect()) as $notificacion)
              <div class="dropdown-item">
                <div class="d-flex flex-column">
                  <span class="font-weight-bold text-primary">{{ $notificacion->titulo ?? ('Requerimiento '.$notificacion->codigo) }}</span>
                  <small class="text-muted">{{ \Carbon\Carbon::parse($notificacion->created_at)->format('d/m/Y H:i') }}</small>
                </div>
              </div>
            @empty
              <div class="dropdown-item text-muted text-center">Sin registros recientes</div>
            @endforelse
          </div>
        </li>

        <!-- Usuario -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded-pill shadow-sm text-white"
             href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
             style="background-color: var(--brand-primary-dark);">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius:12px;min-width:240px;">
            <div class="dropdown-item text-center bg-light py-3">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=64" alt="Avatar" class="rounded-circle mb-2">
              <strong class="text-dark d-block">{{ Auth::user()->name }}</strong>
              <p class="text-muted small mb-0">{{ Auth::user()->cargo ?? 'Cargo no asignado' }}</p>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex align-items-center px-3 py-2 text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> <span>Cerrar sesión</span>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

 <!-- Sidebar -->
  <aside class="main-sidebar elevation-4">
    <a href="#" class="brand-link text-center brand-area">
      <img src="{{ asset('img/logo.png.png') }}" style="width:25px;height:25px;margin-right:8px;">
      <span class="brand-text font-weight-bold">UNIENERGIA ABC</span>
    </a>
    <div class="sidebar">
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column">
           <li class="nav-item">
          <a href="{{ route('bienvenida') }}" 
             class="nav-link {{ request()->routeIs('bienvenida') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home" style="color: var(--brand-secondary);"></i>
            <p class="ml-2 mb-0">Bienvenida</p>
          </a>
        </li>

          <li class="nav-item">
            <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tools" style="color: var(--brand-accent);"></i>
              <p class="ml-2 mb-0">Mantenimiento</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('requerimientos.index') }}" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt" style="color: var(--brand-info);"></i>
              <p class="ml-2 mb-0">Requerimientos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('control_cartas.index') }}" 
              class="nav-link {{ request()->routeIs('control_cartas.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-envelope" style="color: var(--brand-success);"></i>
                <p class="ml-2 mb-0">Cartas SO-PRO</p>
            </a>
        </li>
        </ul>
      </nav>
    </div>
  </aside>


  <!-- Contenido principal (SCROLL AQUÍ) -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0 heading-font" style="color:#333;">Bienvenido, {{ Auth::user()->name }}</h1>
          <h5 class="text-muted" style="margin-top:4px;">{{ Auth::user()->cargo ?? 'Cargo no asignado' }} • {{ now()->format('d/m/Y') }}</h5>
        </div>
        <div>
          <a href="{{ route('requerimientos.index') }}" class="btn btn-brand">
            <i class="fas fa-plus mr-1"></i> Nuevo requerimiento
          </a>
        </div>
      </div>
    </div>

    <div class="container-fluid">

      {{-- KPIs --}}
      <div class="dashboard-safe-container kpi-block">
        <div class="row stat-row stat-row-lg-nowrap">
          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-primary">
              <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $kpi['total_mes'] ?? 0 }}</span></div>
                <div class="stat-label">Requerimientos (mes)</div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-info">
              <div class="stat-icon"><i class="fas fa-clock"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $kpi['hoy'] ?? 0 }}</span></div>
                <div class="stat-label">Hoy</div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-success">
              <div class="stat-icon"><i class="fas fa-list-ol"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ number_format($kpi['prom_items'] ?? 0, 1) }}</span></div>
                <div class="stat-label">Ítems por requerimiento</div>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-primary">
              <div class="stat-icon"><i class="fas fa-building"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $topArea->area_solicitante ?? '—' }}</span></div>
                <div class="stat-label">Top área (mes)</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Actividad reciente + Barras por área --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-stream mr-1"></i>Actividad reciente</div>
            <div class="card-body">
              <ul class="list-unstyled mb-0">
                @forelse($actividad as $a)
                  <li class="mb-3 d-flex align-items-start">
                    <i class="fas fa-file-alt mr-2 text-primary mt-1"></i>
                    <div>
                      <strong>{{ $a->codigo }}</strong> • {{ $a->area_solicitante }}
                      <div class="text-muted small">
                        {{ $a->nombre_solicitante }} — {{ \Carbon\Carbon::parse($a->created_at)->diffForHumans() }}
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="text-muted">Sin movimientos recientes</li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-chart-bar mr-1"></i>Requerimientos por área (mes)</div>
            <div class="card-body">
              <canvas id="chartAreas"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Tendencia 30 días + Calendario --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-chart-line mr-1"></i>Tendencia últimos 30 días</div>
            <div class="card-body">
              <canvas id="chartDias"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="far fa-calendar-alt mr-1"></i>Calendario</div>
            <div class="card-body p-0">
              <div id="calendar" style="min-height: 480px;"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- (Opcional) Más tarjetas de decisión aquí --}}

    </div> <!-- /.container-fluid -->
  </div> <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © {{ date('Y') }}</strong> Todos los derechos reservados.
  </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Chart.js + FullCalendar (JS correcto v6) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>

<!-- (Opcional) DataTables si lo necesitas en esta vista -->
<!--
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
-->
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
  // Notificaciones: ocultar badge al abrir
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });

  // Datos PHP -> JS
  const porArea = @json($porArea);
  const porDia  = @json($porDia);
  const eventos = @json($eventos);

  // Chart: Barras por área
  (function(){
    const el = document.getElementById('chartAreas');
    if (!el) return;
    new Chart(el, {
      type: 'bar',
      data: {
        labels: porArea.map(x => x.area),
        datasets: [{ label: 'Requerimientos', data: porArea.map(x => x.total) }]
      },
      options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true } } }
    });
  })();

  // Chart: Línea por día (últimos 30)
  (function(){
    const el = document.getElementById('chartDias');
    if (!el) return;
    new Chart(el, {
      type: 'line',
      data: {
        labels: porDia.map(x => x.dia),
        datasets: [{ label:'Requerimientos', data: porDia.map(x => x.total), tension:.3, fill:false }]
      },
      options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ y:{ beginAtZero:true } } }
    });
  })();

  // Calendario
  (function(){
    const el = document.getElementById('calendar');
    if (!el) return;
    const calendar = new FullCalendar.Calendar(el, {
      initialView: 'dayGridMonth',
      height: 'auto',
      headerToolbar: { start: 'title', center: '', end: 'prev,next today' },
      events: eventos.map(e => ({
        title: `${e.codigo} • ${e.area} • ${e.servicio}`,
        start: e.start,
        url: `{{ url('/requerimientos') }}/${e.id}`
      })),
      eventClick: function(info){
        info.jsEvent.preventDefault();
        if (info.event.url) window.open(info.event.url, '_blank');
      }
    });
    calendar.render();
  })();
</script>

</body>
</html>
