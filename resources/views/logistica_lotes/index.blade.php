<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>ROP2026 LOTE IX</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

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
    .is-danger .stat-icon{ background:rgba(239,68,68,.12); color:#ef4444; }
    .stat-meta{ display:flex; flex-direction:column; color:#25334a; }
    .stat-kpi span{ font-weight:700; font-size:clamp(20px,3.5vw,28px); letter-spacing:-.5px; line-height:1; }
    .stat-label{ font-size:.85rem; opacity:.8; }

    .card {
      border-radius: 18px;
      border: 1px solid rgba(0,0,0,.05);
      box-shadow: 0 14px 34px rgba(15,23,42,.06);
    }

    .card-header {
      background: linear-gradient(180deg, #ffffff, #f9fafb);
      font-weight: 600;
      letter-spacing: .2px;
    }

    .btn {
      border-radius: 999px !important;
      font-weight: 600;
      letter-spacing: .2px;
      transition: all .2s ease;
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981, #047857);
      border: none;
      box-shadow: 0 8px 20px rgba(16,185,129,.35);
    }
    .btn-success:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 32px rgba(16,185,129,.45);
    }

    .btn-primary {
      background: linear-gradient(135deg, #003366, #002B5C);
      border: none;
      box-shadow: 0 6px 18px rgba(0,51,102,.35);
    }

    .btn-info {
      background: linear-gradient(135deg, #0ea5e9, #0369a1);
      border: none;
      box-shadow: 0 6px 16px rgba(14,165,233,.35);
    }

    .btn-warning {
      background: rgba(245,158,11,.15);
      border: none;
      color: #b45309;
    }
    .btn-warning:hover {
      background: rgba(245,158,11,.25);
    }

    .btn-danger {
      background: rgba(239,68,68,.12);
      border: none;
      color: #ef4444;
    }
    .btn-danger:hover {
      background: rgba(239,68,68,.22);
    }

    .btn-secondary.btn-sm {
      background: rgba(100,116,139,.12);
      border: none;
      color: #475569;
    }

    .table {
      border-collapse: separate !important;
      border-spacing: 0 8px;
    }

    .table thead th {
      background: #f8fafc !important;
      border: none !important;
      font-size: .78rem;
      text-transform: uppercase;
      letter-spacing: .05em;
      color: #475569;
      padding: .75rem;
    }

    .table tbody tr {
      background: #ffffff;
      box-shadow: 0 6px 18px rgba(15,23,42,.06);
      transition: transform .18s ease, box-shadow .18s ease;
    }

    .table tbody tr:hover {
      transform: translateY(-1px);
      box-shadow: 0 14px 32px rgba(15,23,42,.12);
    }

    .table tbody td {
      border: none !important;
      vertical-align: middle;
      padding: .65rem .75rem;
      font-size: .9rem;
      color: #1e293b;
    }

    .input-group .form-control {
      border-radius: 999px 0 0 999px;
    }

    .input-group .btn {
      border-radius: 0 999px 999px 0 !important;
    }

    .modal-content {
      border-radius: 20px !important;
      box-shadow: 0 24px 48px rgba(15,23,42,.25);
    }

    .modal-header {
      border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .modal-footer {
      border-top: 1px solid rgba(0,0,0,.05);
    }

    .form-control,
    .custom-select,
    textarea {
      border-radius: 12px;
      font-size: .9rem;
      transition: border-color .15s ease, box-shadow .15s ease;
    }

    .form-control:focus,
    .custom-select:focus,
    textarea:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,.18);
    }

    .estado-select {
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.78rem;
      padding: 4px 10px;
      border: none;
      outline: none;
      cursor: pointer;
      min-width: 140px;
      text-align: center;
      transition: all .2s ease;
    }
    .estado-badge {
      border-radius: 999px;
      font-weight: 600;
      font-size: 0.78rem;
      padding: 5px 12px;
      display: inline-block;
      min-width: 140px;
      text-align: center;
    }

    /* Tabla ancha tipo hoja de cálculo: todas las columnas visibles, con
       scroll horizontal (sin botones para desplegar nada). */
    .tabla-rop th, .tabla-rop td { white-space: nowrap; }
    .tabla-rop td.wrap { white-space: normal; }
    .tabla-rop .col-asunto { min-width: 280px; max-width: 360px; white-space: normal; }
    .tabla-rop .col-carpeta { max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* Barra de scroll horizontal "pegajosa": siempre alcanzable sin bajar
       hasta el final de la tabla, se queda pegada al fondo de la pantalla
       mientras la tabla está a la vista. */
    .rop-scroll-sticky {
      overflow-x: auto;
      overflow-y: hidden;
      height: 14px;
      position: sticky;
      bottom: 0;
      background: #f1f5f9;
      border-top: 1px solid #e2e8f0;
      z-index: 20;
    }
    .rop-scroll-sticky > div { height: 1px; }
  </style>

</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  <!-- Navbar (simple) -->
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

      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <li class="nav-item dropdown mr-3">
          <a class="nav-link position-relative" href="#" id="notificacionesFirmaDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell fa-lg text-white"></i>
            @if($documentosPendientesFirma->isNotEmpty())
              <span id="notiFirmaBadge" class="badge badge-danger position-absolute" style="top:-4px;right:-8px;font-size:.65rem;">
                {{ $documentosPendientesFirma->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificacionesFirmaDropdown" style="min-width:320px;max-height:400px;overflow-y:auto;">
            <h6 class="dropdown-header font-weight-bold text-dark">🔏 Pendientes de tu firma</h6>
            <div class="dropdown-divider"></div>
            @forelse($documentosPendientesFirma as $pendiente)
              <div class="dropdown-item">
                <div class="d-flex flex-column">
                  <span class="font-weight-bold text-primary">{{ $pendiente->cod_log }}</span>
                  <small class="text-muted">{{ $pendiente->asunto ?: 'Sin asunto' }} — {{ $pendiente->estado }}</small>
                </div>
              </div>
            @empty
              <div class="dropdown-item text-muted text-center">Sin documentos pendientes de firma</div>
            @endforelse
          </div>
        </li>
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
              <strong class="text-dark d-block">{{ Auth::user()->name }}</strong>
              <p class="text-muted small mb-0">{{ Auth::user()->cargo ?? 'Usuario activo' }}</p>
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
        @if(Auth::user()->puedeGestionarBoletas())
        <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users" style="color: var(--brand-accent);"></i>
            <p>
              RRHH
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-2">
            <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                <p>
                  2026
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('boletas.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar nav-icon" style="color: var(--brand-accent);"></i>
                    <p>Boletas 2026</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                <p>
                  2027
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('boletas.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar nav-icon" style="color: var(--brand-accent);"></i>
                    <p>Boletas 2027</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('boletas.index') }}" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar" style="color: var(--brand-accent);"></i>
            <p class="ml-2 mb-0">Mis Boletas</p>
          </a>
        </li>
        @endif
        @endunless

          @if(Auth::user()->tieneAccesoCompleto())
          <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase" style="color: var(--brand-info);"></i>
              <p>
                Administración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ml-2">
              <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                  <p>
                    2026
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('requerimientos.index', ['anio' => 2026]) }}"
                      class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                      <i class="fas fa-file-alt nav-icon" style="color: var(--brand-info);"></i>
                      <p>Requerimientos</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                  <p>
                    2027
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('requerimientos.index', ['anio' => 2027]) }}"
                      class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                      <i class="fas fa-file-alt nav-icon" style="color: var(--brand-info);"></i>
                      <p>Requerimientos</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

        <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder-open" style="color: var(--brand-info);"></i>
            <p>
              Control Cartas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview ml-2">
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
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
                <li class="nav-item">
                  <a href="{{ route('cartas_hse.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-hard-hat nav-icon" style="color: var(--brand-info);"></i>
                    <p>HSE</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
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
                <li class="nav-item">
                  <a href="{{ route('cartas_hse.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_hse.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-hard-hat nav-icon" style="color: var(--brand-info);"></i>
                    <p>HSE</p>
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

<div class="content-wrapper p-4">
<div class="content-header py-3 border-bottom" style="background-color:#f9fafb;">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0 font-weight-bold" style="color:#333; font-size:1.35rem;">
            📦 ROP2026 LOTE IX
          </h1>
          <div class="text-muted" style="font-size:.9rem;">Control y seguimiento de órdenes — Logística Lote IX</div>
        </div>
        @if(Auth::user()->tieneAccesoCompleto())
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarLote">
                <i class="fas fa-plus mr-1"></i> Nuevo Registro
        </button>
        @endif
      </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3 shadow-sm border-0" style="border-radius:12px;">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3 shadow-sm border-0" style="border-radius:12px;">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <div class="dashboard-safe-container mt-3">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center flex-wrap" style="gap: 1.25rem;">
                        <strong class="text-muted small text-uppercase mr-1"><i class="fas fa-users mr-1"></i> Equipo Logística</strong>
                        @forelse($equipoLogistica as $miembro)
                            @php
                                $activo = $miembro->last_login_at && $miembro->last_login_at->gt(now()->subMinutes(15));
                            @endphp
                            <div class="d-flex align-items-center" style="gap:.4rem;">
                                @if($miembro->foto_perfil)
                                    <img src="{{ asset('storage/'.$miembro->foto_perfil) }}" class="rounded-circle" width="26" height="26" style="object-fit:cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($miembro->name) }}&background=003366&color=fff&size=26" class="rounded-circle" width="26" height="26">
                                @endif
                                <span class="small">
                                    {{ $miembro->name }}
                                    @if($activo)
                                        <span class="text-success">● activo</span>
                                    @else
                                        <span class="text-muted">— {{ $miembro->last_login_at ? $miembro->last_login_at->diffForHumans() : 'sin conexiones' }}</span>
                                    @endif
                                </span>
                            </div>
                        @empty
                            <span class="text-muted small">Sin usuarios de Logística registrados.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row stat-row stat-row-lg-nowrap">

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="stat-card is-primary">
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalRegistros }}</span>
                    </div>
                    <span class="stat-label">Total Órdenes</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="stat-card is-info">
                <div class="stat-icon" style="background: rgba(245, 158, 11, .12); color: #b45309;">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalEnProceso }}</span>
                    </div>
                    <span class="stat-label">En Proceso</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="stat-card is-success">
                <div class="stat-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalEjecutado }}</span>
                    </div>
                    <span class="stat-label">Ejecutado</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="stat-card is-danger">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalAlerta }}</span>
                    </div>
                    <span class="stat-label">Vencidas / Observadas</span>
                </div>
            </div>
        </div>

    </div>
</div>

    <section class="content mt-4">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-7">
                    <form action="{{ route('logistica_lotes.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Buscar por código, carta, asunto..."
                                value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                @if(request('search') || request('estado_filtro'))
                                    <a href="{{ route('logistica_lotes.index') }}" class="btn btn-secondary">
                                        Limpiar
                                    </a>
                                @endif
                            </div>
                        </div>
                        <select name="estado_filtro" class="form-control ml-2" style="max-width:220px;" onchange="this.form.submit()">
                            <option value="">Todos los estados</option>
                            @foreach(\App\Models\LogisticaLote::ESTADOS as $estadoOpcion)
                                <option value="{{ $estadoOpcion }}" {{ request('estado_filtro') === $estadoOpcion ? 'selected' : '' }}>{{ $estadoOpcion }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-0"> <div class="table-responsive" id="ropTableWrap">
                        <table class="table table-hover mb-0 tabla-rop" id="ropTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cod. Log</th>
                                    <th>Carta origen</th>
                                    <th class="col-asunto">Asunto</th>
                                    <th class="col-carpeta">Carpeta</th>
                                    <th>Cód. Único</th>
                                    <th>Tipo Solicitud</th>
                                    <th>Atención</th>
                                    <th>Responsable (firma pend.)</th>
                                    <th class="text-center">Estado</th>
                                    <th>N° OC/OS</th>
                                    <th>F. OC/OS</th>
                                    <th>RUC</th>
                                    <th>Empresa Ganadora</th>
                                    <th>C. Costo</th>
                                    <th>Moneda</th>
                                    <th>Monto IGV</th>
                                    <th>Forma Pago</th>
                                    <th>F. Entrega</th>
                                    <th>Ord. Firmada</th>
                                    <th>Ejecución</th>
                                    <th>% Ejec.</th>
                                    <th>Factura</th>
                                    <th>Monto Fact.</th>
                                    <th>F. Venc.</th>
                                    <th>F. Pago</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $estadoColores = [
                                        'PENDIENTE' => ['bg' => '#e5e7eb', 'text' => '#374151'],
                                        'EN REVISION' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
                                        'BUENA PRO' => ['bg' => '#cffafe', 'text' => '#0e7490'],
                                        'EN PROCESO' => ['bg' => '#fef3c7', 'text' => '#b45309'],
                                        'EN EJECUCION' => ['bg' => '#ffedd5', 'text' => '#c2410c'],
                                        'EJECUTADO' => ['bg' => '#d1fae5', 'text' => '#047857'],
                                        'OBSERVADO' => ['bg' => '#fce7f3', 'text' => '#be185d'],
                                        'ORDEN VENCIDA' => ['bg' => '#fee2e2', 'text' => '#b91c1c'],
                                        'ANULADO' => ['bg' => '#e2e8f0', 'text' => '#1e293b'],
                                    ];
                                @endphp
                                @forelse ($lotes as $index => $lote)
                                    @php $color = $estadoColores[$lote->estado] ?? ['bg' => '#e5e7eb', 'text' => '#374151']; @endphp
                                    <tr>
                                        <td>{{ $lotes->firstItem() + $index }}</td>
                                        <td class="font-weight-bold">{{ $lote->cod_log }}</td>
                                        <td>
                                            {{ $lote->numero_carta ?? '—' }}
                                            @if($lote->carta_type)
                                                <span class="badge badge-pill badge-light border">{{ match($lote->carta_type) {
                                                    \App\Models\ControlCarta::class => 'SO-PRO',
                                                    \App\Models\CartaFis::class => 'FIS',
                                                    \App\Models\CartaIpf::class => 'IPF',
                                                    \App\Models\CartaMan::class => 'MAN',
                                                    \App\Models\CartaLog::class => 'LOG',
                                                    \App\Models\CartaHse::class => 'HSE',
                                                    default => '—',
                                                } }}</span>
                                            @endif
                                        </td>
                                        <td class="wrap col-asunto">{{ $lote->asunto ?: '—' }}</td>
                                        <td class="col-carpeta" title="{{ $lote->carpeta }}">{{ $lote->carpeta ?: '—' }}</td>
                                        <td>{{ $lote->codigo_unico ?: '—' }}</td>
                                        <td>{{ $lote->tipo_solicitud ?: '—' }}</td>
                                        <td>{{ $lote->atencion ?: '—' }}</td>
                                        <td>{{ $lote->responsableFirma->name ?? '—' }}</td>
                                       <td class="text-center">
                                            @if(Auth::user()->esLogistica())
                                            <select class="form-control form-control-sm cambio-estado-rapido"
                                                    data-id="{{ $lote->id }}"
                                                    style="border-radius: 20px; font-weight: bold; font-size: 0.78rem; border: none; padding: 2px 10px;
                                                        background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                                @foreach(\App\Models\LogisticaLote::ESTADOS as $estadoOpcion)
                                                    <option value="{{ $estadoOpcion }}" {{ $lote->estado === $estadoOpcion ? 'selected' : '' }}>{{ $estadoOpcion }}</option>
                                                @endforeach
                                            </select>
                                            @else
                                            <span class="estado-badge" style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">{{ $lote->estado }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $lote->nro_oc_os ?: '—' }}</td>
                                        <td>{{ $lote->emision_oc_os ? \Carbon\Carbon::parse($lote->emision_oc_os)->format('d/m/Y') : '—' }}</td>
                                        <td>{{ $lote->ruc ?: '—' }}</td>
                                        <td>{{ $lote->empresa_ganadora ?: '—' }}</td>
                                        <td>{{ $lote->centro_costo ?: '—' }}</td>
                                        <td>{{ $lote->moneda ?: '—' }}</td>
                                        <td>{{ $lote->monto_igv !== null ? number_format($lote->monto_igv, 2) : '—' }}</td>
                                        <td>{{ $lote->forma_pago ?: '—' }}</td>
                                        <td>{{ $lote->fecha_entrega ? \Carbon\Carbon::parse($lote->fecha_entrega)->format('d/m/Y') : '—' }}</td>
                                        <td>{{ $lote->orden_firmada ? 'SÍ' : 'NO' }}</td>
                                        <td>{{ $lote->ejecucion ?: 'Sin iniciar' }}</td>
                                        <td>{{ $lote->porcentaje_ejecucion !== null ? $lote->porcentaje_ejecucion.'%' : '—' }}</td>
                                        <td>{{ $lote->factura ?: '—' }}</td>
                                        <td>{{ $lote->monto_factura !== null ? number_format($lote->monto_factura, 2) : '—' }}</td>
                                        <td>{{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/Y') : '—' }}</td>
                                        <td>{{ $lote->fecha_pago ? \Carbon\Carbon::parse($lote->fecha_pago)->format('d/m/Y') : '—' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#modalVerLote{{ $lote->id }}" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if(Auth::user()->esLogistica())
                                            <button class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#modalEditarLote{{ $lote->id }}" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-secondary mr-1 btn-historial"
                                                    data-toggle="modal" data-target="#modalHistorialLote"
                                                    data-url="{{ route('logistica_lotes.historial', $lote->id) }}"
                                                    title="Historial de cambios">
                                                <i class="fas fa-history"></i>
                                            </button>
                                            @if(Auth::user()->tieneAccesoCompleto())
                                            <form action="{{ route('logistica_lotes.destroy', $lote->id) }}" method="POST" class="d-inline-block"
                                                  onsubmit="return confirm('¿Eliminar el registro {{ $lote->cod_log }}? Esta acción no se puede deshacer.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="27" class="text-center py-4 text-muted">No se encontraron registros de logística.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <p class="text-muted small">
                            Mostrando del {{ $lotes->firstItem() }} al {{ $lotes->lastItem() }}
                            de un total de {{ $lotes->total() }} registros.
                        </p>
                        </table>

                    </div>
                    <div class="rop-scroll-sticky" id="ropScrollSticky">
                        <div id="ropScrollStickyInner"></div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $lotes->links() }}
            </div>
        </div>
    </section>
    <a href="{{ route('logistica_lotes.export.excel') }}" class="btn btn-success shadow-sm">
        <i class="fas fa-file-excel mr-2"></i> Exportar Backup Excel
    </a>
</div>

@if(Auth::user()->tieneAccesoCompleto())
<!-- Modal Agregar (solo administración): cod_log, carta de origen, observación -->
<div class="modal fade" id="modalAgregarLote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#003366,#002B5C); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="fas fa-boxes mr-2"></i> Nuevo Registro ROP</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('logistica_lotes.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small">
                        Este formulario solo inicia el registro. Logística Lima completa el resto del proceso
                        (estado, proveedor, montos, órdenes) desde su propia edición.
                    </p>
                    <div class="form-group">
                        <label><strong>Cod. Logística (N° ROP)</strong></label>
                        <input type="text" class="form-control border-primary" name="cod_log" required placeholder="Ej: ROP260004">
                    </div>

                    <div class="form-group">
                        <label><strong>Carta de origen</strong></label>
                        <div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenControlCarta" name="origen_tipo" value="control_carta" class="custom-control-input" checked>
                                <label class="custom-control-label" for="origenControlCarta">Control de Cartas (SO-PRO)</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenCartaFis" name="origen_tipo" value="carta_fis" class="custom-control-input">
                                <label class="custom-control-label" for="origenCartaFis">Cartas FIS</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenCartaIpf" name="origen_tipo" value="carta_ipf" class="custom-control-input">
                                <label class="custom-control-label" for="origenCartaIpf">Cartas IPF</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenCartaMan" name="origen_tipo" value="carta_man" class="custom-control-input">
                                <label class="custom-control-label" for="origenCartaMan">Cartas MAN</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenCartaLog" name="origen_tipo" value="carta_log" class="custom-control-input">
                                <label class="custom-control-label" for="origenCartaLog">Cartas LOG</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="origenCartaHse" name="origen_tipo" value="carta_hse" class="custom-control-input">
                                <label class="custom-control-label" for="origenCartaHse">Cartas HSE</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="grupoOrigenControlCarta">
                        <label>Carta SO-PRO</label>
                        <select class="form-control" name="origen_id" id="selectOrigenControlCarta">
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['control_carta'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="grupoOrigenCartaFis" style="display:none;">
                        <label>Carta FIS</label>
                        <select class="form-control" name="origen_id" id="selectOrigenCartaFis" disabled>
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['carta_fis'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="grupoOrigenCartaIpf" style="display:none;">
                        <label>Carta IPF</label>
                        <select class="form-control" name="origen_id" id="selectOrigenCartaIpf" disabled>
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['carta_ipf'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="grupoOrigenCartaMan" style="display:none;">
                        <label>Carta MAN</label>
                        <select class="form-control" name="origen_id" id="selectOrigenCartaMan" disabled>
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['carta_man'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="grupoOrigenCartaLog" style="display:none;">
                        <label>Carta LOG</label>
                        <select class="form-control" name="origen_id" id="selectOrigenCartaLog" disabled>
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['carta_log'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="grupoOrigenCartaHse" style="display:none;">
                        <label>Carta HSE</label>
                        <select class="form-control" name="origen_id" id="selectOrigenCartaHse" disabled>
                            <option value="">Selecciona una carta...</option>
                            @foreach($cartasDisponibles['carta_hse'] ?? [] as $carta)
                                <option value="{{ $carta->id }}" data-descripcion="{{ $carta->descripcion }}">{{ $carta->codigo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Asunto</strong></label>
                        <input type="text" class="form-control" name="asunto" id="asuntoNuevoRegistro" placeholder="¿Qué se está solicitando?">
                    </div>

                    <div class="form-group">
                        <label><strong>Observación</strong></label>
                        <textarea class="form-control" name="observacion" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@foreach($lotes as $lote)

@if(Auth::user()->esLogistica())
<!-- Modal Editar (solo Logística Lima): todo excepto cod_log/carta origen/observación -->
<div class="modal fade" id="modalEditarLote{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-warning" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Procesar Registro: {{ $lote->cod_log }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('logistica_lotes.update', $lote->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row bg-light p-3 rounded mb-3">
                        <div class="col-md-3">
                            <small class="text-uppercase text-muted d-block">Cod. Logística</small>
                            <strong>{{ $lote->cod_log }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-uppercase text-muted d-block">Carta de origen</small>
                            <strong>{{ $lote->numero_carta ?? '—' }}</strong>
                        </div>
                        <div class="col-md-3">
                            <small class="text-uppercase text-muted d-block">Asunto</small>
                            <span>{{ $lote->asunto ?: '—' }}</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-uppercase text-muted d-block">Observación (de administración)</small>
                            <span>{{ $lote->observacion ?: '—' }}</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label><strong>Carpeta</strong></label>
                            <input type="text" class="form-control" name="carpeta" value="{{ $lote->carpeta }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Estado</strong></label>
                            <select class="form-control custom-select border-warning" name="estado">
                                @foreach(\App\Models\LogisticaLote::ESTADOS as $estadoOpcion)
                                    <option value="{{ $estadoOpcion }}" {{ $lote->estado === $estadoOpcion ? 'selected' : '' }}>{{ $estadoOpcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Código Único</strong></label>
                            <input type="text" class="form-control" name="codigo_unico" value="{{ $lote->codigo_unico }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label><strong>Atención (quién procesa la orden)</strong></label>
                            <select class="form-control custom-select" name="atencion">
                                <option value="">Sin asignar</option>
                                @foreach($usuariosLogistica as $usuarioLogistica)
                                    <option value="{{ $usuarioLogistica->name }}" {{ $lote->atencion === $usuarioLogistica->name ? 'selected' : '' }}>{{ $usuarioLogistica->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Responsable (pendiente de firma)</strong></label>
                            <select class="form-control custom-select" name="responsable_id">
                                <option value="">Sin asignar</option>
                                @foreach($usuariosRegistrados as $usuarioRegistrado)
                                    <option value="{{ $usuarioRegistrado->id }}" {{ (int) $lote->responsable_id === $usuarioRegistrado->id ? 'selected' : '' }}>{{ $usuarioRegistrado->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Quien tiene pendiente firmar la orden de compra o la conformidad.</small>
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Tipo de Solicitud</strong></label>
                            <select class="form-control custom-select" name="tipo_solicitud">
                                <option value="">Selecciona...</option>
                                @foreach(\App\Models\LogisticaLote::TIPOS_SOLICITUD as $tipoOpcion)
                                    <option value="{{ $tipoOpcion }}" {{ $lote->tipo_solicitud === $tipoOpcion ? 'selected' : '' }}>{{ $tipoOpcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label><strong>Fecha Emisión</strong></label>
                            <input type="date" class="form-control" name="fecha_emision" value="{{ $lote->fecha_emision ? \Carbon\Carbon::parse($lote->fecha_emision)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>N° OC / OS</strong></label>
                            <input type="text" class="form-control" name="nro_oc_os" value="{{ $lote->nro_oc_os }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-file-invoice-dollar mr-2"></i> Datos Comerciales y Proveedor</h6>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>RUC</strong></label>
                            <input type="text" class="form-control" name="ruc" value="{{ $lote->ruc }}" maxlength="11">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><strong>Empresa Ganadora</strong></label>
                            <input type="text" class="form-control" name="empresa_ganadora" value="{{ $lote->empresa_ganadora }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Centro de Costo</strong></label>
                            <input type="text" class="form-control" name="centro_costo" value="{{ $lote->centro_costo }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 form-group">
                            <label><strong>Moneda</strong></label>
                            <select class="form-control custom-select" name="moneda">
                                <option value="">Selecciona...</option>
                                @foreach(\App\Models\LogisticaLote::MONEDAS as $monedaOpcion)
                                    <option value="{{ $monedaOpcion }}" {{ $lote->moneda === $monedaOpcion ? 'selected' : '' }}>{{ $monedaOpcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Monto + IGV</strong></label>
                            <input type="number" step="0.01" class="form-control" name="monto_igv" value="{{ $lote->monto_igv }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Forma de Pago</strong></label>
                            <select class="form-control custom-select forma-pago-select" name="forma_pago" data-target="#formaPagoOtro{{ $lote->id }}">
                                <option value="">Selecciona...</option>
                                @foreach(\App\Models\LogisticaLote::FORMAS_PAGO as $formaOpcion)
                                    <option value="{{ $formaOpcion }}" {{ $lote->forma_pago === $formaOpcion ? 'selected' : '' }}>{{ $formaOpcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group" id="formaPagoOtro{{ $lote->id }}" style="{{ in_array($lote->forma_pago, \App\Models\LogisticaLote::FORMAS_PAGO) || !$lote->forma_pago ? 'display:none;' : '' }}">
                            <label><strong>Especificar forma de pago</strong></label>
                            <input type="text" class="form-control" name="forma_pago_otro" value="{{ !in_array($lote->forma_pago, \App\Models\LogisticaLote::FORMAS_PAGO) ? $lote->forma_pago : '' }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-success font-weight-bold mb-3"><i class="fas fa-tasks mr-2"></i> Documentación, Ejecución y Pago</h6>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Emisión OC/OS</strong></label>
                            <input type="date" class="form-control" name="emision_oc_os" value="{{ $lote->emision_oc_os ? \Carbon\Carbon::parse($lote->emision_oc_os)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Factura</strong></label>
                            <input type="text" class="form-control" name="factura" value="{{ $lote->factura }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Entrega</strong></label>
                            <input type="date" class="form-control" name="fecha_entrega" value="{{ $lote->fecha_entrega ? \Carbon\Carbon::parse($lote->fecha_entrega)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Orden Firmada</strong></label>
                            <select class="form-control custom-select" name="orden_firmada">
                                <option value="0" {{ !$lote->orden_firmada ? 'selected' : '' }}>NO</option>
                                <option value="1" {{ $lote->orden_firmada ? 'selected' : '' }}>SI</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Ejecución</strong></label>
                            <select class="form-control custom-select" name="ejecucion">
                                <option value="">Sin iniciar</option>
                                @foreach(\App\Models\LogisticaLote::EJECUCIONES as $ejecucionOpcion)
                                    <option value="{{ $ejecucionOpcion }}" {{ $lote->ejecucion === $ejecucionOpcion ? 'selected' : '' }}>{{ $ejecucionOpcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>% Ejecución</strong></label>
                            <input type="number" min="0" max="100" class="form-control" name="porcentaje_ejecucion" value="{{ $lote->porcentaje_ejecucion }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Monto Factura</strong></label>
                            <input type="number" step="0.01" class="form-control" name="monto_factura" value="{{ $lote->monto_factura }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Venc.</strong></label>
                            <input type="date" class="form-control" name="fecha_vencimiento" value="{{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha de Pago</strong></label>
                            <input type="date" class="form-control" name="fecha_pago" value="{{ $lote->fecha_pago ? \Carbon\Carbon::parse($lote->fecha_pago)->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning px-4 font-weight-bold">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Modal Ver (todos los que acceden al módulo) -->
<div class="modal fade" id="modalVerLote{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-light d-flex align-items-center">
                <h5 class="modal-title font-weight-bold" style="color: #003366;">
                    <i class="fas fa-file-invoice mr-2"></i> DETALLE DEL REGISTRO: {{ $lote->cod_log }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                @php $color = $estadoColores[$lote->estado] ?? ['bg' => '#e5e7eb', 'text' => '#374151']; @endphp
                <div class="row mb-4 bg-light p-3 rounded shadow-sm">
                    <div class="col-md-4">
                        <small class="text-uppercase text-muted d-block">Estado</small>
                        <span class="estado-badge" style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }};">{{ $lote->estado }}</span>
                    </div>
                    <div class="col-md-4 text-center">
                        <small class="text-uppercase text-muted d-block">Progreso</small>
                        <div class="progress mt-1" style="height: 15px; border-radius: 10px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $lote->porcentaje_ejecucion ?? 0 }}%;" aria-valuenow="{{ $lote->porcentaje_ejecucion ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $lote->porcentaje_ejecucion ?? 0 }}%
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <small class="text-uppercase text-muted d-block">Código Único</small>
                        <span class="h6 font-weight-bold text-dark">{{ $lote->codigo_unico ?? 'N/A' }}</span>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-info-circle mr-2"></i> Datos Generales</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Carpeta / Lote</label>
                        <p class="font-weight-bold">{{ $lote->carpeta ?: '—' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Atención</label>
                        <p class="font-weight-bold">{{ $lote->atencion ?: '—' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Responsable (firma pendiente)</label>
                        <p class="font-weight-bold">{{ $lote->responsableFirma->name ?? '—' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Fecha Emisión</label>
                        <p class="font-weight-bold">{{ $lote->fecha_emision ? \Carbon\Carbon::parse($lote->fecha_emision)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Carta de Origen</label>
                        <p class="font-weight-bold text-primary">
                            {{ $lote->numero_carta ?? '—' }}
                            @if($lote->carta_type)
                                <span class="badge badge-pill badge-light border">{{ match($lote->carta_type) {
                                    \App\Models\ControlCarta::class => 'SO-PRO',
                                    \App\Models\CartaFis::class => 'FIS',
                                    \App\Models\CartaIpf::class => 'IPF',
                                    \App\Models\CartaMan::class => 'MAN',
                                    \App\Models\CartaLog::class => 'LOG',
                                    \App\Models\CartaHse::class => 'HSE',
                                    default => '—',
                                } }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-8">
                        <label class="text-muted small mb-0">Asunto</label>
                        <p class="font-weight-bold">{{ $lote->asunto ?: '—' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="text-muted small mb-0">Tipo de Solicitud</label>
                        <p class="font-weight-bold">{{ $lote->tipo_solicitud ?: '—' }}</p>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-building mr-2"></i> Información del Proveedor</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">RUC</label>
                        <p class="font-weight-bold">{{ $lote->ruc ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-0">Empresa Ganadora</label>
                        <p class="font-weight-bold text-uppercase">{{ $lote->empresa_ganadora ?? 'Sin asignar' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Centro de Costo</label>
                        <p class="font-weight-bold">{{ $lote->centro_costo }}</p>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-money-bill-wave mr-2"></i> Documentación y Montos</h6>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">N° OC / OS</label>
                        <p class="font-weight-bold">{{ $lote->nro_oc_os ?? 'Pte.' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Emisión OC/OS</label>
                        <p class="font-weight-bold">{{ $lote->emision_oc_os ? \Carbon\Carbon::parse($lote->emision_oc_os)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Moneda</label>
                        <p class="font-weight-bold">{{ $lote->moneda ?? '—' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Monto IGV</label>
                        <p class="font-weight-bold">{{ number_format($lote->monto_igv ?? 0, 2) }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">N° Factura</label>
                        <p class="font-weight-bold">{{ $lote->factura ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Monto Factura</label>
                        <p class="font-weight-bold">{{ number_format($lote->monto_factura ?? 0, 2) }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">F. Vencimiento</label>
                        <p class="font-weight-bold text-danger">{{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">F. Pago</label>
                        <p class="font-weight-bold">{{ $lote->fecha_pago ? \Carbon\Carbon::parse($lote->fecha_pago)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-0">Forma de Pago</label>
                        <p class="font-weight-bold">{{ $lote->forma_pago ?: '—' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-0">Ejecución</label>
                        <p class="font-weight-bold">{{ $lote->ejecucion ?: 'Sin iniciar' }}</p>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-truck mr-2"></i> Seguimiento</h6>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small mb-0">Fecha Entrega</label>
                        <p class="font-weight-bold">{{ $lote->fecha_entrega ? \Carbon\Carbon::parse($lote->fecha_entrega)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small mb-0">Orden Firmada</label>
                        <p class="font-weight-bold">
                            @if($lote->orden_firmada)
                                <span class="text-success"><i class="fas fa-check-circle"></i> Sí</span>
                            @else
                                <span class="text-danger"><i class="fas fa-times-circle"></i> No</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="bg-light p-3 rounded mb-3" style="border-left: 4px solid #17a2b8;">
                    <label class="text-muted small mb-1">Observación (administración)</label>
                    <p class="mb-0">{{ $lote->observacion ?? 'Sin observaciones registradas.' }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Creado por</small>
                        <span>{{ $lote->creador->name ?? '—' }} ({{ optional($lote->created_at)->format('d/m/Y H:i') }})</span>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Última modificación por</small>
                        <span>{{ $lote->modificador->name ?? '—' }} ({{ optional($lote->updated_at)->format('d/m/Y H:i') }})</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light justify-content-between">
                <div class="small text-muted">
                    Creado: {{ optional($lote->created_at)->format('d/m/Y H:i') }}
                </div>
                <div>
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cerrar</button>
                    <a href="{{ route('logistica_lotes.pdf', $lote->id) }}" class="btn btn-danger px-4 shadow-sm">
                        <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endforeach

<!-- Modal Historial (auditoría, compartido) -->
<div class="modal fade" id="modalHistorialLote" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius:18px;">
      <div class="modal-header text-white" style="background: linear-gradient(135deg, #003366, #002B5C); border-radius:18px 18px 0 0;">
        <h5 class="modal-title mb-0 font-weight-bold">
          <i class="fas fa-history mr-1"></i> Historial — <span id="historialLoteCodigo">—</span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="historialLoteCargando" class="text-center text-muted py-4" style="display:none;">
          <i class="fas fa-spinner fa-spin mr-1"></i> Cargando historial...
        </div>
        <table class="table table-sm table-bordered">
          <thead class="thead-light">
            <tr>
              <th>Fecha</th>
              <th>Usuario</th>
              <th>Acción</th>
              <th>Cambios</th>
            </tr>
          </thead>
          <tbody id="historialLoteCuerpo">
            <tr><td colspan="4" class="text-center text-muted">Sin datos.</td></tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

 <footer class="main-footer text-center">
    <strong>Unienergia ABC © {{ date('Y') }}</strong> Todos los derechos reservados.
  </footer>
<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Alterna qué selector de carta de origen se envía (SO-PRO / FIS / IPF / MAN / LOG)
var ORIGENES_CARTA_MAP = {
    'control_carta': 'ControlCarta',
    'carta_fis': 'CartaFis',
    'carta_ipf': 'CartaIpf',
    'carta_man': 'CartaMan',
    'carta_log': 'CartaLog',
    'carta_hse': 'CartaHse',
};
function toggleOrigenCarta() {
    var tipo = $('input[name="origen_tipo"]:checked').val();
    $.each(ORIGENES_CARTA_MAP, function (valor, sufijo) {
        var activo = valor === tipo;
        $('#grupoOrigen' + sufijo).toggle(activo);
        $('#selectOrigen' + sufijo).prop('disabled', !activo);
    });
}
$(document).on('change', 'input[name="origen_tipo"]', toggleOrigenCarta);
$(function () { toggleOrigenCarta(); });

// Al elegir una carta como origen, se autocompleta el Asunto con su
// descripción para agilizar el registro (el campo sigue siendo editable).
$.each(ORIGENES_CARTA_MAP, function (valor, sufijo) {
    $(document).on('change', '#selectOrigen' + sufijo, function () {
        var descripcion = $(this).find(':selected').data('descripcion');
        if (descripcion) {
            $('#asuntoNuevoRegistro').val(descripcion);
        }
    });
});

// Barra de scroll horizontal pegajosa: sincronizada con el scroll real de
// la tabla, siempre alcanzable sin bajar hasta el final.
(function () {
    var wrap = document.getElementById('ropTableWrap');
    var table = document.getElementById('ropTable');
    var sticky = document.getElementById('ropScrollSticky');
    var stickyInner = document.getElementById('ropScrollStickyInner');
    if (!wrap || !table || !sticky || !stickyInner) return;

    function syncWidth() {
        stickyInner.style.width = table.scrollWidth + 'px';
    }
    syncWidth();
    window.addEventListener('resize', syncWidth);
    window.addEventListener('load', syncWidth);

    var syncing = false;
    wrap.addEventListener('scroll', function () {
        if (syncing) return;
        syncing = true;
        sticky.scrollLeft = wrap.scrollLeft;
        syncing = false;
    });
    sticky.addEventListener('scroll', function () {
        if (syncing) return;
        syncing = true;
        wrap.scrollLeft = sticky.scrollLeft;
        syncing = false;
    });
})();

// Muestra el campo "especificar" cuando la forma de pago es OTRO
$(document).on('change', '.forma-pago-select', function () {
    var $otro = $($(this).data('target'));
    if ($(this).val() === 'OTRO') {
        $otro.show();
    } else {
        $otro.hide();
    }
});

// Cambio rápido de estado (solo Logística Lima ve este selector, el backend igual lo valida)
const ESTADO_COLORES = {
    'PENDIENTE': { bg: '#e5e7eb', text: '#374151' },
    'EN REVISION': { bg: '#dbeafe', text: '#1d4ed8' },
    'BUENA PRO': { bg: '#cffafe', text: '#0e7490' },
    'EN PROCESO': { bg: '#fef3c7', text: '#b45309' },
    'EN EJECUCION': { bg: '#ffedd5', text: '#c2410c' },
    'EJECUTADO': { bg: '#d1fae5', text: '#047857' },
    'OBSERVADO': { bg: '#fce7f3', text: '#be185d' },
    'ORDEN VENCIDA': { bg: '#fee2e2', text: '#b91c1c' },
    'ANULADO': { bg: '#e2e8f0', text: '#1e293b' }
};

$(document).on('change', '.cambio-estado-rapido', function() {
    let loteId = $(this).data('id');
    let nuevoEstado = $(this).val();
    let select = $(this);

    $.ajax({
        url: "{{ url('logistica_lotes') }}/" + loteId + "/actualizar-estado",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            estado: nuevoEstado
        },
        success: function() {
            const color = ESTADO_COLORES[nuevoEstado] || { bg: '#e5e7eb', text: '#374151' };
            select.css({ 'background-color': color.bg, 'color': color.text });

            Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        },
        error: function() {
            Swal.fire('Error', 'No se pudo actualizar el estado', 'error');
        }
    });
});

// Historial de auditoría
function escapeHtml(str) {
    return $('<div>').text(str == null ? '' : str).html();
}

$(document).on('click', '.btn-historial', function() {
    var url = $(this).data('url');
    var $cuerpo = $('#historialLoteCuerpo');
    var $cargando = $('#historialLoteCargando');

    $('#historialLoteCodigo').text('...');
    $cuerpo.empty();
    $cargando.show();

    fetch(url, { headers: { 'Accept': 'application/json' } })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            $cargando.hide();
            $('#historialLoteCodigo').text(data.codigo);

            if (!data.logs || data.logs.length === 0) {
                $cuerpo.html('<tr><td colspan="4" class="text-center text-muted">Sin registros de auditoría.</td></tr>');
                return;
            }

            var etiquetas = { creado: 'Creado', actualizado: 'Actualizado', eliminado: 'Eliminado' };
            var filas = data.logs.map(function(log) {
                var cambios = log.cambios ? JSON.stringify(log.cambios) : '—';
                return '<tr>' +
                    '<td>' + escapeHtml(log.fecha || '—') + '</td>' +
                    '<td>' + escapeHtml(log.usuario) + '</td>' +
                    '<td>' + escapeHtml(etiquetas[log.accion] || log.accion) + '</td>' +
                    '<td><small class="text-muted">' + escapeHtml(cambios) + '</small></td>' +
                    '</tr>';
            });
            $cuerpo.html(filas.join(''));
        })
        .catch(function() {
            $cargando.hide();
            $cuerpo.html('<tr><td colspan="4" class="text-center text-danger">No se pudo cargar el historial.</td></tr>');
        });
});

$(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });
$(function(){ $('#notificacionesFirmaDropdown').on('click', function(){ $('#notiFirmaBadge').hide(); }); });
</script>

</body>
</html>
