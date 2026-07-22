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
    .is-danger .stat-icon{ background:rgba(220,53,69,.12); color:#dc3545; }
    .stat-meta{ display:flex; flex-direction:column; color:#25334a; }
    .stat-kpi span{ font-weight:700; font-size:clamp(20px,3.5vw,28px); letter-spacing:-.5px; line-height:1; }
    .stat-label{ font-size:.85rem; opacity:.8; }

    /* ===== Feed de actividad (estilo red social) ===== */
    .feed-item{ padding-bottom:.85rem; border-bottom:1px solid rgba(0,0,0,.05); }
    .feed-item:last-child{ border-bottom:none; padding-bottom:0; }
    .feed-avatar{ width:38px; height:38px; border-radius:50%; object-fit:cover; flex-shrink:0; }
    .feed-icon-badge{
      width:38px; height:38px; border-radius:50%; flex-shrink:0;
      display:flex; align-items:center; justify-content:center; font-size:.9rem;
    }
    .feed-icon-primary{ background:rgba(13,110,253,.12); color:#0d6efd; }
    .feed-icon-info{ background:rgba(43,183,246,.12); color:#2bb7f6; }
    .feed-icon-success{ background:rgba(24,181,143,.12); color:#18b58f; }
    .feed-icon-danger{ background:rgba(220,53,69,.12); color:#dc3545; }

    /* ===== Avatares en Últimas conexiones / Cumpleaños ===== */
    .social-avatar{ width:38px; height:38px; border-radius:50%; object-fit:cover; flex-shrink:0; }
  </style>

<style>
/* ===========================
   UX/UI MODERNO – UNIENERGIA
   =========================== */

/* ===== BOTONES CORPORATIVOS ===== */
.btn-brand {
  background: linear-gradient(135deg, #2563eb, #1e40af);
  color: #fff !important;
  border: none;
  border-radius: 999px;
  padding: 0.55rem 1.2rem;
  font-weight: 600;
  letter-spacing: .2px;
  box-shadow: 0 6px 16px rgba(37, 99, 235, .35);
  transition: all .25s ease;
}
.btn-brand:hover {
  transform: translateY(-1px);
  box-shadow: 0 10px 28px rgba(37, 99, 235, .45);
}

/* ===== KPI CARDS – MÁS INNOVADOR ===== */
.stat-card {
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  background: linear-gradient(180deg, #ffffff, #f8fafc);
  border: 1px solid rgba(0,0,0,.04);
}
.stat-card::after {
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at top right, rgba(37,99,235,.12), transparent 60%);
  opacity: .6;
  pointer-events: none;
}
.stat-card::before {
  content: "";
  position: absolute;
  left: 0;
  top: 12%;
  bottom: 12%;
  width: 4px;
  border-radius: 6px;
}
.stat-card.is-primary::before { background: #2563eb; }
.stat-card.is-info::before    { background: #0ea5e9; }
.stat-card.is-success::before { background: #10b981; }

/* ===== ICONOS KPI ===== */
.stat-icon {
  background: linear-gradient(135deg, #eef2ff, #e0e7ff);
  box-shadow: inset 0 0 0 1px rgba(37,99,235,.15);
}
.stat-icon i {
  font-size: 1.15rem;
}

/* ===== CARDS GENERALES (ACTIVIDAD, GRÁFICOS) ===== */
.card-clean {
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,.05);
  box-shadow: 0 10px 26px rgba(15,23,42,.06);
  overflow: hidden;
}
.card-clean .card-header {
  background: linear-gradient(180deg, #ffffff, #f9fafb);
  font-weight: 600;
  border-bottom: 1px solid rgba(0,0,0,.05);
}

/* ===== LISTA ACTIVIDAD ===== */
.card-clean ul li {
  padding: .35rem 0;
}
.card-clean ul li i {
  opacity: .85;
}

/* ===== SIDEBAR MÁS MODERNA ===== */
.nav-sidebar .nav-link {
  padding: .55rem .9rem;
  font-size: .9rem;
  transition: all .2s ease;
}
.nav-sidebar .nav-link.active {
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.12),
              0 6px 18px rgba(0,0,0,.25);
}
.nav-sidebar .nav-link p {
  margin-left: .6rem;
}

/* ===== DROPDOWNS MÁS ELEGANTES ===== */
.dropdown-menu {
  border-radius: 14px;
  box-shadow: 0 20px 40px rgba(0,0,0,.15);
}

/* ===== FOOTER ===== */
.main-footer {
  background: linear-gradient(90deg, #020617, #0f172a);
  color: #cbd5f5;
  border-top: none;
}

/* ===== SCROLL MÁS SUAVE ===== */
.content-wrapper {
  scroll-behavior: smooth;
}
.nav-treeview .nav-link {
  font-size: .85rem;
  opacity: .85;
}

.nav-treeview .nav-link.active {
  background: linear-gradient(90deg, rgba(0,168,107,.18), transparent);
  color: var(--brand-accent) !important;
}

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
                  <span class="font-weight-bold text-primary">{{ $notificacion->titulo ?? $notificacion->codigo ?? $notificacion->pozo ?? $notificacion->periodo ?? 'Nuevo registro' }}</span>
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
            @if(Auth::user()->foto_perfil)
              <img src="{{ asset('storage/'.Auth::user()->foto_perfil) }}" alt="Avatar" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
            @endif
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius:12px;min-width:240px;">
            <div class="dropdown-item text-center bg-light py-3">
              @if(Auth::user()->foto_perfil)
                <img src="{{ asset('storage/'.Auth::user()->foto_perfil) }}" alt="Avatar" class="rounded-circle mb-2" style="width:64px;height:64px;object-fit:cover;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=64" alt="Avatar" class="rounded-circle mb-2">
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
  <aside class="main-sidebar elevation-4">
    <a href="#" class="brand-link text-center brand-area">
      <img src="{{ asset('img/logo.png.png') }}" style="width:25px;height:25px;margin-right:8px;">
      <span class="brand-text font-weight-bold">UNIENERGIA ABC</span>
    </a>
    <div class="sidebar">
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column"
    data-widget="treeview"
    data-accordion="true">
           <li class="nav-item">
          <a href="{{ route('bienvenida') }}" 
             class="nav-link {{ request()->routeIs('bienvenida') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home" style="color: var(--brand-secondary);"></i>
            <p class="ml-2 mb-0">Bienvenida</p>
          </a>
        </li>

        @if(Auth::user()->puedeVerMantenimiento())
        <li class="nav-item has-treeview {{ request()->routeIs('reportes.*') || request()->routeIs('anomalias.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('reportes.*') || request()->routeIs('anomalias.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tools" style="color: var(--brand-accent);"></i>
            <p>
              Mantenimiento
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-2">
            <li class="nav-item">
              <a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list nav-icon" style="color: var(--brand-accent);"></i>
                <p>Reportes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('anomalias.index') }}" class="nav-link {{ request()->routeIs('anomalias.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-triangle nav-icon" style="color: var(--brand-danger);"></i>
                <p>Anomalías</p>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @unless(Auth::user()->esLogistica())
        <li class="nav-item">
          <a href="{{ route('boletas.index') }}" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar" style="color: var(--brand-accent);"></i>
            <p class="ml-2 mb-0">{{ Auth::user()->puedeGestionarBoletas() ? 'Gestionar Boletas' : 'Mis Boletas' }}</p>
          </a>
        </li>
        @endunless

          @if(Auth::user()->tieneAccesoCompleto())
          <li class="nav-item">
            <a href="{{ route('requerimientos.index') }}" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt" style="color: var(--brand-info);"></i>
              <p class="ml-2 mb-0">Requerimientos</p>
            </a>
          </li>

        <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder-open" style="color: var(--brand-info);"></i>
            <p>
              Control Cartas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview ml-2">
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                <p>
                  2026
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('control_cartas.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('control_cartas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                    <p>SO-PRO</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_fis.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_fis.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                    <p>FIS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_ipf.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_ipf.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-drafting-compass nav-icon" style="color: var(--brand-accent);"></i>
                    <p>IPF</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_man.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                    <p>MAN</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_log.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_log.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-warehouse nav-icon" style="color: var(--brand-accent);"></i>
                    <p>LOG</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                <p>
                  2027
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('control_cartas.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('control_cartas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                    <p>SO-PRO</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_fis.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_fis.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                    <p>FIS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_ipf.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_ipf.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-drafting-compass nav-icon" style="color: var(--brand-accent);"></i>
                    <p>IPF</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_man.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                    <p>MAN</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_log.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_log.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-warehouse nav-icon" style="color: var(--brand-accent);"></i>
                    <p>LOG</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="{{ route('logistica_lotes.index') }}"
            class="nav-link {{ request()->routeIs('logistica_lotes.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes" style="color: var(--brand-primary-light);"></i>
              <p class="ms-2 mb-0">ROP2026 LOTE IX</p>
          </a>
      </li>
          @endif

          @if(Auth::user()->esLogistica())
          <li class="nav-item">
            <a href="{{ route('logistica_lotes.index') }}"
              class="nav-link {{ request()->routeIs('logistica_lotes.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes" style="color: var(--brand-primary-light);"></i>
                <p class="ms-2 mb-0">ROP2026 LOTE IX</p>
            </a>
          </li>
          @endif

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
        <div class="alert alert-info shadow-sm" style="border-left:4px solid var(--brand-info);">
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

      @unless($vistaLogistica)
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
      @endunless

      @if($vistaLogistica)
      {{-- Panel ROP2026 LOTE IX: mismos indicadores y gráficas del backup Excel,
           exclusivo del rol logística (Miguel, Esmeralda, Yahaira) --}}
      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-stream mr-1"></i>Actividad reciente — ROP2026 Lote IX</div>
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
                      <a href="{{ $item['url'] }}" class="text-muted ml-2" title="Ver">
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
            <div class="card-header bg-white"><i class="fas fa-chart-pie mr-1"></i>Distribución por Estado</div>
            <div class="card-body">
              <canvas id="chartRopEstados"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-chart-pie mr-1"></i>Tasa de Ejecutados vs Pendientes</div>
            <div class="card-body">
              <canvas id="chartRopCategorias"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card card-clean">
            <div class="card-header bg-white"><i class="fas fa-chart-line mr-1"></i>Rendimiento Anual de ROP — {{ $logisticaStats['anio_actual'] }}</div>
            <div class="card-body">
              <canvas id="chartRopMensual"></canvas>
            </div>
          </div>
        </div>
      </div>

      @endif

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

  // Panel ROP2026 Lote IX (solo rol logística)
  const logisticaStats = @json($logisticaStats);

  (function(){
    const el = document.getElementById('chartRopEstados');
    if (!el || !logisticaStats) return;
    const porEstado = logisticaStats.por_estado;
    new Chart(el, {
      type: 'pie',
      data: {
        labels: Object.keys(porEstado),
        datasets: [{ data: Object.values(porEstado) }]
      },
      options: { responsive:true, plugins:{ legend:{ display:true, position:'right' } } }
    });
  })();

  (function(){
    const el = document.getElementById('chartRopCategorias');
    if (!el || !logisticaStats) return;
    new Chart(el, {
      type: 'doughnut',
      data: {
        labels: ['Ejecutado', 'En proceso', 'Vencido/Observado', 'Anulado'],
        datasets: [{ data: [
          logisticaStats.ejecutados,
          logisticaStats.en_proceso,
          logisticaStats.vencidos_observados,
          logisticaStats.anulados
        ] }]
      },
      options: { responsive:true, plugins:{ legend:{ display:true, position:'right' } } }
    });
  })();

  (function(){
    const el = document.getElementById('chartRopMensual');
    if (!el || !logisticaStats) return;
    const nombresMes = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    const porMes = logisticaStats.por_mes;
    new Chart(el, {
      type: 'line',
      data: {
        labels: nombresMes,
        datasets: [{ label: 'Expedientes creados', data: nombresMes.map((_, i) => porMes[i + 1] ?? 0), tension:.3, fill:false }]
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
