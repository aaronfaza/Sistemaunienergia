<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISTEMA INTEGRADO DE GESTION v1</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- FullCalendar (CSS correcto v6) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">

  <!-- (Opcional) DataTables Bootstrap 4 si lo usaras aquí -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> -->

  <style>
    :root{
      /* Paleta corporativa sobria — sin gradientes, sin tonos oscuros de fondo */
      --brand-primary:#1F3A5F;
      --brand-primary-dark:#16283F;
      --brand-accent:#2F6F4E;
      --brand-info:#0E7490;
      --brand-danger:#B91C1C;
      --brand-warning:#B45309;
      --text-on-brand:#ffffff;
      --header-h:52px;
      --footer-h:40px;

      --page-bg:#F3F4F6;
      --surface:#ffffff;
      --border:#D9DCE1;
      --border-strong:#C4C9D2;
      --text-primary:#1F2937;
      --text-secondary:#6B7280;

      --sidebar-bg:#ffffff;
      --sidebar-border:#D9DCE1;
      --sidebar-text:#3F4A5A;
      --sidebar-text-active:var(--brand-primary);
    }

    * { font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif; }

    html, body{ height:100%; overflow:hidden; }
    .wrapper{ height:100vh; overflow:hidden; }

    .navbar-uni{ background:var(--brand-primary); border-bottom:1px solid var(--brand-primary-dark); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand{ color:var(--text-on-brand); }
    .main-header{ position:sticky; top:0; z-index:1035; height:var(--header-h); }

    /* ===== Sidebar claro, sobrio ===== */
    .main-sidebar{
      background:var(--sidebar-bg) !important;
      border-right:1px solid var(--sidebar-border);
      display:flex;
      flex-direction:column;
    }
    .brand-area{ background:var(--sidebar-bg); border-bottom:1px solid var(--sidebar-border); }
    .brand-area .brand-text{ color:var(--brand-primary); font-weight:600; letter-spacing:.2px; }
    .sidebar{ flex:1 1 auto; display:flex; flex-direction:column; min-height:0; padding-bottom:0!important; }
    .sidebar-scroll{ flex:1 1 auto; overflow-y:auto; }

    .nav-sidebar .nav-link{
      color:var(--sidebar-text) !important;
      border-radius:2px;
      margin:1px 8px;
      font-weight:500;
      font-size:.88rem;
    }
    .nav-sidebar .nav-link.active{
      background:#EAEEF3 !important;
      color:var(--sidebar-text-active) !important;
      font-weight:600;
      box-shadow:inset 3px 0 0 var(--brand-primary);
    }
    .nav-sidebar .nav-link:hover{ background:#F3F4F6 !important; color:var(--sidebar-text-active) !important; }
    .nav-sidebar .nav-treeview .nav-link{ margin-left:16px; }
    .nav-sidebar .nav-link p, .nav-sidebar .nav-link .right{ color:inherit; }

    /* ===== Pie del sidebar: usuario + Cerrar sesión ===== */
    .sidebar-user-footer{
      flex-shrink:0;
      border-top:1px solid var(--sidebar-border);
      background:#FAFAFB;
      padding:12px 14px;
    }
    .sidebar-user-footer .avatar{
      width:34px; height:34px; border-radius:2px; object-fit:cover; flex-shrink:0;
    }
    .sidebar-user-footer .nombre{ font-size:.83rem; font-weight:600; color:var(--text-primary); line-height:1.2; }
    .sidebar-user-footer .cargo{ font-size:.72rem; color:var(--text-secondary); line-height:1.2; }
    .sidebar-logout-btn{
      display:flex; align-items:center; justify-content:center; gap:.4rem;
      width:100%; margin-top:8px; padding:.4rem; border-radius:2px;
      background:var(--surface); color:var(--brand-danger); font-weight:600; font-size:.8rem;
      border:1px solid var(--border); text-decoration:none;
    }
    .sidebar-logout-btn:hover{ background:#FEF2F2; border-color:#F3C6C6; color:var(--brand-danger); text-decoration:none; }

    .content-wrapper{
      background-color:var(--page-bg);
      height:calc(100vh - var(--header-h) - var(--footer-h));
      overflow:auto;
      -webkit-overflow-scrolling:touch;
    }
    .main-footer{ position:sticky; bottom:0; z-index:1020; background:var(--surface); border-top:1px solid var(--border); font-size:.8rem; color:var(--text-secondary); }

    @media (min-width:992px){ :root{ --header-h:56px; } }

    .card-clean{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-clean .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }

    .btn{ border-radius:3px!important; font-weight:600; font-size:.85rem; box-shadow:none!important; transition:background-color .12s ease; }
    .btn-brand{ background:var(--brand-primary); border:1px solid var(--brand-primary-dark); color:#fff!important; }
    .btn-brand:hover{ background:var(--brand-primary-dark); color:#fff; }
    .btn-primary{ background:var(--brand-primary); border:1px solid var(--brand-primary-dark); }
    .btn-primary:hover{ background:var(--brand-primary-dark); }
    .btn-info{ background:var(--surface); border:1px solid var(--brand-info); color:var(--brand-info); }
    .btn-info:hover{ background:#ECFAFB; color:var(--brand-info); }
    .btn-warning{ background:var(--surface); border:1px solid #F5D08A; color:var(--brand-warning); }
    .btn-warning:hover{ background:#FFFBEB; color:var(--brand-warning); }
    .btn-danger{ background:var(--surface); border:1px solid #F3C6C6; color:var(--brand-danger); }
    .btn-danger:hover{ background:#FEF2F2; color:var(--brand-danger); }
    .btn-outline-secondary{ border-radius:3px!important; }
    .btn-fw{ font-weight:600; }

    /* ===== KPI cards — planas, con borde, sin sombra ===== */
    .dashboard-safe-container{ padding-left:clamp(16px,4vw,36px); padding-right:clamp(16px,4vw,36px); }
    .stat-row{ margin-left:-8px; margin-right:-8px; }
    .stat-row > [class*="col-"]{ padding-left:8px; padding-right:8px; }
    @media (min-width: 992px){ .stat-row-lg-nowrap{ flex-wrap:nowrap!important; } }
    .stat-card{
      display:flex; align-items:center; gap:12px;
      padding:12px 14px; border-radius:4px; min-height:76px;
      background:var(--surface); border:1px solid var(--border); border-left:3px solid var(--border-strong);
    }
    .stat-card.is-primary{ border-left-color:var(--brand-primary); }
    .stat-card.is-info{ border-left-color:var(--brand-info); }
    .stat-card.is-success{ border-left-color:var(--brand-accent); }
    .stat-card.is-warning{ border-left-color:var(--brand-warning); }
    .stat-card.is-danger{ border-left-color:var(--brand-danger); }
    .stat-icon{ width:34px; height:34px; border-radius:3px; display:grid; place-items:center; flex-shrink:0; background:var(--page-bg); }
    .stat-icon i{ font-size:16px; }
    .is-primary .stat-icon{ color:var(--brand-primary); }
    .is-info .stat-icon{ color:var(--brand-info); }
    .is-success .stat-icon{ color:var(--brand-accent); }
    .is-warning .stat-icon{ color:var(--brand-warning); }
    .is-danger .stat-icon{ color:var(--brand-danger); }
    .stat-meta{ display:flex; flex-direction:column; color:var(--text-primary); }
    .stat-kpi span{ font-weight:700; font-size:clamp(18px,2.4vw,22px); line-height:1.1; }
    .stat-label{ font-size:.78rem; color:var(--text-secondary); }

    table thead th{
      background:#F3F4F6!important; border:1px solid var(--border)!important; font-size:.72rem;
      text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); padding:.55rem .7rem; white-space:nowrap;
    }
    table tbody tr{ background:var(--surface); }
    table tbody tr:hover{ background:#F8FAFC; }
    table tbody td{ border:1px solid var(--border)!important; vertical-align:middle; padding:.55rem .7rem; font-size:.86rem; color:var(--text-primary); }

    .filters-row{ background:var(--surface); border:1px solid var(--border); border-radius:4px; padding:.75rem 1rem; }

    .modal-content{ border-radius:4px!important; box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .modal-header, .modal-footer{ border-color:var(--border); }

    .form-control, .custom-select{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    .empty-state{ padding:2rem 1rem; text-align:center; color:var(--text-secondary); }
    .empty-state i{ font-size:1.8rem; color:var(--border-strong); display:block; margin-bottom:.5rem; }

    .badge{ font-weight:600; padding:.3rem .5rem; border-radius:3px; font-size:.72rem; }

    /* ===== Feed de actividad reciente (estilo tarjeta plana, sin sombras) ===== */
    .feed-item{ padding-bottom:.85rem; border-bottom:1px solid var(--border); }
    .feed-item:last-child{ border-bottom:none; padding-bottom:0; }
    .feed-avatar{ width:38px; height:38px; border-radius:3px; object-fit:cover; flex-shrink:0; }
    .feed-icon-badge{
      width:38px; height:38px; border-radius:3px; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; font-size:.9rem;
      background:var(--page-bg);
    }
    .feed-icon-primary{ color:var(--brand-primary); }
    .feed-icon-info{ color:var(--brand-info); }
    .feed-icon-success{ color:var(--brand-accent); }
    .feed-icon-danger{ color:var(--brand-danger); }

    /* ===== Avatares en Últimas conexiones / Cumpleaños ===== */
    .social-avatar{ width:38px; height:38px; border-radius:3px; object-fit:cover; flex-shrink:0; }
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
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-flex align-items-center ml-2">
          <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width:22px;height:22px;">
        </li>
      </ul>

      <!-- Notificaciones + Perfil -->
      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <!-- Notificaciones -->
        <li class="nav-item dropdown mr-2">
          <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell text-white"></i>
            @if(isset($notificaciones) && $notificaciones->count() > 0)
              <span id="notiBadge" class="badge badge-danger position-absolute" style="top:-2px;right:-6px;font-size:.6rem;">
                {{ $notificaciones->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border" aria-labelledby="notificacionesDropdown" style="min-width:300px;max-height:380px;overflow-y:auto;border-radius:4px;">
            <h6 class="dropdown-header font-weight-bold text-dark">Últimos registros</h6>
            <div class="dropdown-divider"></div>
            @forelse(($notificaciones ?? collect()) as $notificacion)
              <div class="dropdown-item">
                <div class="d-flex flex-column">
                  <span class="font-weight-bold" style="color:var(--brand-primary);">{{ $notificacion->titulo ?? $notificacion->codigo ?? $notificacion->pozo ?? $notificacion->periodo ?? 'Nuevo registro' }}</span>
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
          <a class="nav-link dropdown-toggle d-flex align-items-center px-2 py-1 text-white"
             href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            @if(Auth::user()->foto_perfil)
              <img src="{{ asset('storage/'.Auth::user()->foto_perfil) }}" alt="Avatar" style="width:28px;height:28px;border-radius:2px;object-fit:cover;">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1F3A5F&color=fff&size=28" alt="Avatar" style="width:28px;height:28px;border-radius:2px;">
            @endif
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border" style="border-radius:4px;min-width:230px;">
            <div class="dropdown-item text-center bg-light py-3">
              @if(Auth::user()->foto_perfil)
                <img src="{{ asset('storage/'.Auth::user()->foto_perfil) }}" alt="Avatar" class="mb-2" style="width:56px;height:56px;border-radius:3px;object-fit:cover;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1F3A5F&color=fff&size=56" alt="Avatar" class="mb-2" style="border-radius:3px;">
              @endif
              <strong class="text-dark d-block">{{ Auth::user()->name }}</strong>
              <p class="text-muted small mb-0">{{ Auth::user()->cargo ?? 'Cargo no asignado' }}</p>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex align-items-center px-3 py-2" href="{{ route('perfil.edit') }}">
              <i class="fas fa-user-circle mr-2"></i> <span>Mi Perfil</span>
            </a>
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
  <aside class="main-sidebar">
    <a href="#" class="brand-link text-center brand-area d-block py-3">
      <img src="{{ asset('img/logo.png.png') }}" style="width:22px;height:22px;margin-right:8px;">
      <span class="brand-text">UNIENERGIA ABC</span>
    </a>
    <div class="sidebar">
      <nav class="mt-3 sidebar-scroll">
        <ul class="nav nav-pills nav-sidebar flex-column"
    data-widget="treeview"
    data-accordion="true">
           <li class="nav-item">
          <a href="{{ route('bienvenida') }}"
             class="nav-link {{ request()->routeIs('bienvenida') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p class="ml-2 mb-0">Bienvenida</p>
          </a>
        </li>

        @if(Auth::user()->puedeVerMantenimiento())
        <li class="nav-item has-treeview {{ request()->routeIs('reportes.*') || request()->routeIs('anomalias.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('reportes.*') || request()->routeIs('anomalias.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tools"></i>
            <p>
              Mantenimiento
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-2">
            <li class="nav-item">
              <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list nav-icon"></i>
                <p>Reportes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('anomalias.index') }}" class="nav-link {{ request()->routeIs('anomalias.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle nav-icon"></i>
                <p>Anomalías</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        <li class="nav-item">
          <a href="{{ route('boletas.index') }}" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar"></i>
            <p class="ml-2 mb-0">{{ Auth::user()->puedeGestionarBoletas() ? 'Gestionar Boletas' : 'Mis Boletas' }}</p>
          </a>
        </li>

          @if(Auth::user()->tieneAccesoCompleto())
          <li class="nav-item">
            <a href="{{ route('requerimientos.index') }}" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p class="ml-2 mb-0">Requerimientos</p>
            </a>
          </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
              Control Cartas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview ml-2">
            <li class="nav-item">
              <a href="{{ route('control_cartas.index') }}"
                class="nav-link {{ request()->routeIs('control_cartas.*') ? 'active' : '' }}">
                <i class="far fa-envelope nav-icon"></i>
                <p>SO-PRO</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('cartas_fis.index') }}"
                class="nav-link {{ request()->routeIs('cartas_fis.*') ? 'active' : '' }}">
                <i class="far fa-clipboard nav-icon"></i>
                <p>FIS</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('logistica_lotes.index') }}"
            class="nav-link {{ request()->routeIs('logistica_lotes.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes"></i>
              <p class="ms-2 mb-0">Logística Lote</p>
          </a>
      </li>
          @endif

        </ul>
      </nav>

      <!-- Pie del sidebar: usuario + Cerrar sesión -->
      <div class="sidebar-user-footer">
        <div class="d-flex align-items-center" style="gap:.6rem;">
          @if(Auth::user()->foto_perfil)
            <img src="{{ asset('storage/'.Auth::user()->foto_perfil) }}" alt="Avatar" class="avatar">
          @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1F3A5F&color=fff&size=34" alt="Avatar" class="avatar">
          @endif
          <div class="text-truncate">
            <div class="nombre text-truncate">{{ Auth::user()->name }}</div>
            <div class="cargo text-truncate">{{ Auth::user()->cargo ?? 'Sin cargo asignado' }}</div>
          </div>
        </div>
        <a href="{{ route('logout') }}" class="sidebar-logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
          <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal (SCROLL AQUÍ) -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0" style="color:var(--text-primary);font-size:1.4rem;font-weight:700;">Bienvenido, {{ Auth::user()->name }}</h1>
          <h5 class="mb-0" style="margin-top:2px;font-weight:400;font-size:.88rem;color:var(--text-secondary);">{{ Auth::user()->cargo ?? 'Cargo no asignado' }} · {{ now()->format('d/m/Y') }}</h5>
        </div>
        @if(Auth::user()->tieneAccesoCompleto())
        <div>
          <a href="{{ route('requerimientos.index') }}" class="btn btn-brand">
            <i class="fas fa-plus mr-1"></i> Nuevo requerimiento
          </a>
        </div>
        @endif
      </div>
    </div>

    <div class="container-fluid">

      @if($vistaPendiente)
        <div class="alert alert-info" style="border-radius:4px;border-left:3px solid var(--brand-info);">
          <i class="fas fa-info-circle mr-2"></i>
          Tu cuenta se creó correctamente, pero todavía no tiene un rol asignado. Un administrador debe asignarte
          un rol para que puedas acceder a los módulos que te correspondan. Mientras tanto, podés completar tu
          <a href="{{ route('perfil.edit') }}">perfil</a> (incluyendo tu correo de recuperación).
        </div>
      @endif

      {{-- KPIs (se adaptan según el rol: Requerimientos para admin, Mantenimiento/Anomalías para mecánico y supervisor) --}}
      <div class="dashboard-safe-container kpi-block">
        <div class="row stat-row stat-row-lg-nowrap">
          @foreach($kpiCards as $card)
            <div class="col-12 col-sm-6 col-md-3 mb-3">
              <div class="stat-card {{ $card['color'] }}">
                <div class="stat-icon"><i class="fas {{ $card['icono'] }}"></i></div>
                <div class="stat-meta">
                  <div class="stat-kpi"><span>{{ $card['valor'] }}</span></div>
                  <div class="stat-label">{{ $card['label'] }}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Actividad reciente (estilo feed social) + gráfico --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-stream mr-1"></i>Actividad reciente</div>
            <div class="card-body">
              <ul class="list-unstyled mb-0 feed-lista">
                @forelse($actividad as $item)
                  <li class="feed-item mb-3 d-flex align-items-start">
                    @if($item['foto'])
                      <img src="{{ asset('storage/'.$item['foto']) }}" alt="{{ $item['usuario'] }}" class="feed-avatar mr-3">
                    @else
                      <span class="feed-icon-badge feed-icon-{{ $item['color'] }} mr-3">
                        <i class="fas {{ $item['icono'] }}"></i>
                      </span>
                    @endif
                    <div class="flex-grow-1">
                      <div>
                        <strong>{{ $item['usuario'] }}</strong>
                        <span class="text-muted">{{ $item['accion'] }}</span>
                      </div>
                      <div class="text-muted small">{{ $item['detalle'] }}</div>
                      <div class="text-muted small">
                        <i class="far fa-clock mr-1"></i>{{ $item['created_at']->diffForHumans() }}
                      </div>
                    </div>
                    @if($item['url'])
                      <a href="{{ $item['url'] }}" target="_blank" class="text-muted ml-2" title="Ver">
                        <i class="fas fa-external-link-alt"></i>
                      </a>
                    @endif
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
            <div class="card-header bg-white">
              <i class="fas fa-chart-bar mr-1"></i>{{ $vistaMantenimiento ? 'Mantenimiento por tipo de equipo (mes)' : ($vistaRRHH ? 'Boletas por periodo (mes)' : ($vistaPendiente ? 'Sin datos' : 'Requerimientos por área (mes)')) }}
            </div>
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

      {{-- Últimas conexiones + Cumpleaños del mes --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-sign-in-alt mr-1"></i>Últimas conexiones</div>
            <div class="card-body">
              <ul class="list-unstyled mb-0">
                @forelse($ultimasConexiones as $u)
                  <li class="mb-3 d-flex align-items-start">
                    @if($u->foto_perfil)
                      <img src="{{ asset('storage/'.$u->foto_perfil) }}" alt="{{ $u->name }}" class="social-avatar mr-2">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=003366&color=fff&size=38" alt="{{ $u->name }}" class="social-avatar mr-2">
                    @endif
                    <div>
                      <strong>{{ $u->name }}</strong>
                      <span class="text-muted small">— {{ $u->cargo ?? 'Sin cargo' }}</span>
                      <div class="text-muted small">
                        {{ $u->last_login_at->diffForHumans() }}
                        ({{ $u->last_login_at->format('d/m/Y H:i') }})
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="text-muted">Aún no hay conexiones registradas.</li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-birthday-cake mr-1"></i>Cumpleaños del mes</div>
            <div class="card-body">
              <ul class="list-unstyled mb-0">
                @forelse($cumpleañosMes as $u)
                  @php $esHoy = $u->fecha_nacimiento->day === now()->day && $u->fecha_nacimiento->month === now()->month; @endphp
                  <li class="mb-3 d-flex align-items-start">
                    @if($u->foto_perfil)
                      <img src="{{ asset('storage/'.$u->foto_perfil) }}" alt="{{ $u->name }}" class="social-avatar mr-2">
                    @else
                      <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=003366&color=fff&size=38" alt="{{ $u->name }}" class="social-avatar mr-2">
                    @endif
                    <div>
                      <strong>{{ $u->name }}</strong>
                      <span class="text-muted small">— {{ $u->cargo ?? 'Sin cargo' }}</span>
                      <div class="text-muted small">
                        {{ $u->fecha_nacimiento->format('d/m') }}
                        @if($esHoy)
                          <span class="badge badge-danger ml-1">¡Hoy!</span>
                        @endif
                      </div>
                    </div>
                  </li>
                @empty
                  <li class="text-muted">Nadie cumple años este mes.</li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>

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
<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display:none;">
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
  const etiquetaSerie = @json($vistaMantenimiento ? 'Mantenimiento' : ($vistaRRHH ? 'Boletas' : ($vistaPendiente ? 'Sin datos' : 'Requerimientos')));

  // Chart: Barras por área / tipo de equipo
  (function(){
    const el = document.getElementById('chartAreas');
    if (!el) return;
    new Chart(el, {
      type: 'bar',
      data: {
        labels: porArea.map(x => x.area),
        datasets: [{ label: etiquetaSerie, data: porArea.map(x => x.total) }]
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
        datasets: [{ label: etiquetaSerie, data: porDia.map(x => x.total), tension:.3, fill:false }]
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
        title: e.titulo,
        start: e.start,
        url: e.url
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
