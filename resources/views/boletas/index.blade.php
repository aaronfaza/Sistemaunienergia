<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Boletas de Pago</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand-primary:#003366;
      --brand-primary-dark:#002B5C;
      --brand-accent:#00A86B;
      --brand-accent-dark:#038b5a;
      --brand-info:#17a2b8;
      --brand-danger:#dc3545;
      --brand-warning:#f59e0b;
      --text-on-brand:#ffffff;
      --header-h:56px;
      --footer-h:44px;

      /* Sidebar claro — sin tonos oscuros */
      --sidebar-bg:#ffffff;
      --sidebar-border:#e7ecf3;
      --sidebar-text:#51607a;
      --sidebar-text-active:var(--brand-primary);
    }

    html, body{ height:100%; overflow:hidden; }
    .wrapper{ height:100vh; overflow:hidden; }

    .navbar-uni{ background:linear-gradient(100deg,var(--brand-primary),var(--brand-primary-dark)); box-shadow:0 2px 8px rgba(0,0,0,.12); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand{ color:var(--text-on-brand); }
    .navbar-uni .nav-link:hover{ opacity:.9; }
    .main-header{ position:sticky; top:0; z-index:1035; height:var(--header-h); }

    /* ===== Sidebar claro, tipo SaaS empresarial ===== */
    .main-sidebar{
      background:var(--sidebar-bg) !important;
      border-right:1px solid var(--sidebar-border);
      display:flex;
      flex-direction:column;
    }
    .brand-area{ background:var(--sidebar-bg); border-bottom:1px solid var(--sidebar-border); }
    .brand-area .brand-text{ color:var(--brand-primary); font-weight:700; }
    .sidebar{ flex:1 1 auto; display:flex; flex-direction:column; min-height:0; padding-bottom:0!important; }
    .sidebar-scroll{ flex:1 1 auto; overflow-y:auto; }

    .nav-sidebar .nav-link{
      color:var(--sidebar-text) !important;
      border-radius:10px;
      margin:2px 10px;
      font-weight:500;
      transition:background .15s ease, color .15s ease;
    }
    .nav-sidebar .nav-link.active{
      background:rgba(0,51,102,.08) !important;
      color:var(--sidebar-text-active) !important;
      font-weight:700;
      box-shadow:inset 3px 0 0 var(--brand-accent);
    }
    .nav-sidebar .nav-link:hover{ background:#f1f5f9 !important; color:var(--sidebar-text-active) !important; }
    .nav-sidebar .nav-treeview .nav-link{ margin-left:18px; }
    .nav-sidebar .nav-link p, .nav-sidebar .nav-link .right{ color:inherit; }

    /* ===== Pie del sidebar: usuario + Cerrar sesión ===== */
    .sidebar-user-footer{
      flex-shrink:0;
      border-top:1px solid var(--sidebar-border);
      background:#f8fafc;
      padding:14px 16px;
    }
    .sidebar-user-footer .avatar{
      width:38px; height:38px; border-radius:50%; object-fit:cover; flex-shrink:0;
    }
    .sidebar-user-footer .nombre{ font-size:.85rem; font-weight:700; color:#1e293b; line-height:1.2; }
    .sidebar-user-footer .cargo{ font-size:.72rem; color:#94a3b8; line-height:1.2; }
    .sidebar-logout-btn{
      display:flex; align-items:center; justify-content:center; gap:.4rem;
      width:100%; margin-top:10px; padding:.5rem; border-radius:10px;
      background:rgba(220,53,69,.08); color:#dc3545; font-weight:600; font-size:.82rem;
      border:none; text-decoration:none; transition:background .15s ease;
    }
    .sidebar-logout-btn:hover{ background:rgba(220,53,69,.16); color:#dc3545; text-decoration:none; }

    .content-wrapper{
      background-color:#f5f7fb;
      height:calc(100vh - var(--header-h) - var(--footer-h));
      overflow:auto;
      -webkit-overflow-scrolling:touch;
    }
    .main-footer{ position:sticky; bottom:0; z-index:1020; background:#fff; border-top:1px solid var(--sidebar-border); }

    @media (min-width:992px){ :root{ --header-h:64px; } }
    .heading-font{ font-family:'Montserrat', sans-serif; }

    .card-clean{ border-radius:18px; border:1px solid rgba(0,0,0,.05); box-shadow:0 10px 28px rgba(15,23,42,.05); }
    .card-clean .card-header{ background:#ffffff; font-weight:600; letter-spacing:.2px; }

    .btn{ border-radius:999px!important; font-weight:600; letter-spacing:.2px; transition:all .2s ease; }
    .btn-brand{ background:linear-gradient(135deg,var(--brand-accent),var(--brand-accent-dark)); border:none; color:#fff!important; box-shadow:0 8px 20px rgba(0,168,107,.3); }
    .btn-brand:hover{ transform:translateY(-1px); box-shadow:0 14px 28px rgba(0,168,107,.4); color:#fff; }
    .btn-primary{ background:linear-gradient(135deg,var(--brand-primary),var(--brand-primary-dark)); border:none; box-shadow:0 6px 18px rgba(0,51,102,.3); }
    .btn-info{ background:linear-gradient(135deg,#22b8cf,var(--brand-info)); border:none; box-shadow:0 6px 16px rgba(23,162,184,.3); }
    .btn-warning{ background:rgba(245,158,11,.12); border:none; color:#b45309; }
    .btn-warning:hover{ background:rgba(245,158,11,.22); color:#b45309; }
    .btn-danger{ background:rgba(220,53,69,.1); border:none; color:#dc3545; }
    .btn-danger:hover{ background:rgba(220,53,69,.18); color:#dc3545; }
    .btn-fw{ font-weight:600; }

    /* ===== KPI cards (mismo lenguaje visual que Bienvenida) ===== */
    .stat-row{ margin-left:-8px; margin-right:-8px; }
    .stat-row > [class*="col-"]{ padding-left:8px; padding-right:8px; }
    .stat-card{
      display:flex; align-items:center; gap:14px;
      padding:14px 16px; border-radius:16px; min-height:88px;
      background:#ffffff; border:1px solid #eef2f7; box-shadow:0 8px 20px rgba(20,30,58,.06);
      transition:transform .2s ease, box-shadow .2s ease;
    }
    .stat-card:hover{ transform:translateY(-2px); box-shadow:0 14px 30px rgba(20,30,58,.1); }
    .stat-icon{ width:46px; height:46px; border-radius:12px; display:grid; place-items:center; flex-shrink:0; }
    .stat-icon i{ font-size:19px; }
    .is-primary .stat-icon{ background:rgba(0,51,102,.1); color:var(--brand-primary); }
    .is-info .stat-icon{ background:rgba(23,162,184,.12); color:var(--brand-info); }
    .is-success .stat-icon{ background:rgba(0,168,107,.12); color:var(--brand-accent-dark); }
    .is-warning .stat-icon{ background:rgba(245,158,11,.14); color:#b45309; }
    .stat-meta{ display:flex; flex-direction:column; color:#25334a; }
    .stat-kpi span{ font-weight:700; font-size:clamp(20px,3vw,26px); letter-spacing:-.5px; line-height:1; }
    .stat-label{ font-size:.82rem; color:#64748b; }

    /* ===== Alerta de boletas pendientes de confirmar ===== */
    .alerta-pendientes{
      background:linear-gradient(135deg,#fffbeb,#fff7ed);
      border:1px solid #fde68a;
      border-radius:16px;
      padding:1rem 1.25rem;
    }
    .alerta-pendientes .icono-alerta{
      width:44px; height:44px; border-radius:50%;
      background:rgba(245,158,11,.16); color:#b45309;
      display:flex; align-items:center; justify-content:center; flex-shrink:0;
      font-size:1.1rem;
    }
    .pendiente-chip{
      display:inline-flex; align-items:center; gap:.5rem;
      background:#ffffff; border:1px solid #fde68a; border-radius:999px;
      padding:.3rem .5rem .3rem .9rem; font-size:.82rem; color:#78350f;
    }

    #tablaBoletas{ border-collapse:separate!important; border-spacing:0 8px; }
    #tablaBoletas thead th{
      background:transparent!important; border:none!important; font-size:.75rem;
      text-transform:uppercase; letter-spacing:.06em; color:#8892a4; padding:.75rem; white-space:nowrap;
    }
    #tablaBoletas tbody tr{ background:#ffffff; box-shadow:0 4px 14px rgba(15,23,42,.05); transition:transform .15s ease, box-shadow .15s ease; }
    #tablaBoletas tbody tr.fila-nueva{ box-shadow:0 4px 14px rgba(245,158,11,.18); }
    #tablaBoletas tbody tr:hover{ transform:translateY(-1px); box-shadow:0 10px 24px rgba(15,23,42,.1); }
    #tablaBoletas tbody td{ border:none!important; vertical-align:middle; padding:.7rem .75rem; font-size:.9rem; color:#334155; }

    .filters-row{ background:#ffffff; border-radius:16px; padding:.85rem 1rem; box-shadow:0 6px 18px rgba(15,23,42,.04); }

    .modal-content{ border-radius:20px!important; box-shadow:0 24px 48px rgba(15,23,42,.2); }
    .modal-header, .modal-footer{ border-color:rgba(0,0,0,.05); }

    .form-control, .custom-select{ border-radius:12px; font-size:.9rem; transition:border-color .15s ease, box-shadow .15s ease; }
    .form-control:focus, .custom-select:focus{ border-color:var(--brand-accent); box-shadow:0 0 0 3px rgba(0,168,107,.15); }

    .empty-state{ padding:2.5rem 1rem; text-align:center; color:#94a3b8; }
    .empty-state i{ font-size:2.2rem; color:#e2e8f0; display:block; margin-bottom:.6rem; }

    .badge{ font-weight:600; padding:.35rem .6rem; border-radius:999px; }
  </style>
</head>

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

      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <li class="nav-item dropdown mr-2">
          <a class="nav-link position-relative" href="#" id="notiBoletasDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell fa-lg text-white"></i>
            @if($boletasPendientesConfirmar->count() > 0)
              <span class="badge badge-warning position-absolute" style="top:-2px;right:-6px;font-size:.62rem;">
                {{ $boletasPendientesConfirmar->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="min-width:300px;max-height:380px;overflow-y:auto;border-radius:14px;">
            <h6 class="dropdown-header font-weight-bold text-dark">Boletas por confirmar</h6>
            <div class="dropdown-divider"></div>
            @forelse($boletasPendientesConfirmar as $pendiente)
              <div class="dropdown-item">
                <div class="d-flex flex-column">
                  <span class="font-weight-bold text-warning">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $pendiente->tipo_label }} · {{ $pendiente->periodo_formateado }}
                  </span>
                  <small class="text-muted">Verifica que esta boleta te pertenece</small>
                </div>
              </div>
            @empty
              <div class="dropdown-item text-muted text-center">No tienes boletas pendientes de confirmar</div>
            @endforelse
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded-pill shadow-sm text-white"
             href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
             style="background-color: rgba(255,255,255,.14);">
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
    <a href="#" class="brand-link text-center brand-area d-block py-3">
      <img src="{{ asset('img/logo.png.png') }}" style="width:25px;height:25px;margin-right:8px;">
      <span class="brand-text font-weight-bold">UNIENERGIA ABC</span>
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
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=38" alt="Avatar" class="avatar">
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

  <!-- Contenido -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid">
        <h1 class="m-0 heading-font" style="color:#1e293b;">{{ $puedeGestionar ? 'Boletas de Pago' : 'Mis Boletas de Pago' }}</h1>
        <h5 class="text-muted" style="margin-top:4px;font-weight:400;">
          {{ $puedeGestionar ? 'Sube y gestiona la boleta de pago de cada trabajador' : 'Aquí encuentras tus boletas de pago registradas' }}
        </h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-radius:12px;border-left:4px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-radius:12px;">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-radius:12px;">
            <ul class="mb-0 pl-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
    </div>

    <div class="container-fluid pt-3">

      {{-- Alerta de boletas pendientes de confirmar (siempre visible si aplica) --}}
      @if($boletasPendientesConfirmar->count() > 0)
        <div class="alerta-pendientes mb-3 d-flex align-items-start" style="gap:1rem;">
          <span class="icono-alerta"><i class="fas fa-exclamation-triangle"></i></span>
          <div class="flex-grow-1">
            <div class="font-weight-bold" style="color:#78350f;">
              Tienes {{ $boletasPendientesConfirmar->count() }} boleta{{ $boletasPendientesConfirmar->count() > 1 ? 's' : '' }} nueva{{ $boletasPendientesConfirmar->count() > 1 ? 's' : '' }} sin confirmar
            </div>
            <div class="text-muted small mb-2">Verifica que cada una realmente te pertenece antes de darla por válida.</div>
            <div class="d-flex flex-wrap" style="gap:.5rem;">
              @foreach($boletasPendientesConfirmar as $pendiente)
                <span class="pendiente-chip">
                  {{ $pendiente->tipo_label }} · {{ $pendiente->periodo_formateado }}
                  <form action="{{ route('boletas.confirmar', $pendiente->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-warning btn-fw" style="padding:.15rem .6rem;font-size:.75rem;">
                      <i class="fas fa-check mr-1"></i>Confirmar
                    </button>
                  </form>
                </span>
              @endforeach
            </div>
          </div>
        </div>
      @endif

      {{-- KPIs --}}
      <div class="row stat-row mb-1">
        @if($puedeGestionar)
          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-primary">
              <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $boletas->count() }}</span></div>
                <div class="stat-label">Boletas mostradas</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-info">
              <div class="stat-icon"><i class="fas fa-users"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $trabajadores->count() }}</span></div>
                <div class="stat-label">Trabajadores registrados</div>
              </div>
            </div>
          </div>
        @else
          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-primary">
              <div class="stat-icon"><i class="fas fa-file-invoice-dollar"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $boletas->count() }}</span></div>
                <div class="stat-label">Total de boletas</div>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card is-warning">
              <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
              <div class="stat-meta">
                <div class="stat-kpi"><span>{{ $boletasPendientesConfirmar->count() }}</span></div>
                <div class="stat-label">Sin confirmar</div>
              </div>
            </div>
          </div>
        @endif
      </div>

      @if($puedeGestionar)
        <div class="card card-clean mb-3">
          <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
              <h3 class="card-title m-0 heading-font" style="color:#1e293b;">Subir nueva boleta</h3>
              <button class="btn btn-brand btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalSubirBoleta">
                <i class="fas fa-upload mr-1"></i> Subir Boleta
              </button>
            </div>
          </div>
        </div>

        <div class="filters-row mb-3">
          <form action="{{ route('boletas.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2 mb-2">
              <select name="trabajador" class="form-control">
                <option value="">Todos los trabajadores</option>
                @foreach($trabajadores as $t)
                  <option value="{{ $t->id }}" {{ request('trabajador') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group mr-2 mb-2">
              <select name="tipo" class="form-control">
                <option value="">Todos los tipos</option>
                @foreach(\App\Models\Boleta::TIPOS as $valor => $etiqueta)
                  <option value="{{ $valor }}" {{ request('tipo') == $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-fw mb-2">
              <i class="fas fa-search mr-1"></i> Filtrar
            </button>
          </form>
        </div>
      @else
        <div class="filters-row mb-3">
          <form action="{{ route('boletas.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2 mb-2">
              <select name="tipo" class="form-control">
                <option value="">Todos los tipos</option>
                @foreach(\App\Models\Boleta::TIPOS as $valor => $etiqueta)
                  <option value="{{ $valor }}" {{ request('tipo') == $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-fw mb-2">
              <i class="fas fa-search mr-1"></i> Filtrar
            </button>
          </form>
        </div>
      @endif

      <div class="card card-clean">
        <div class="card-header bg-white border-bottom">
          <h3 class="card-title mb-0 heading-font" style="color:#1e293b;">
            <i class="fas fa-file-invoice-dollar mr-1" style="color:var(--brand-accent);"></i> {{ $puedeGestionar ? 'Todas las boletas' : 'Boletas registradas' }}
          </h3>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="tablaBoletas" class="table table-hover align-middle text-center" style="width:100%;">
              <thead class="thead-light">
                <tr class="text-muted">
                  @if($puedeGestionar)
                    <th>Trabajador</th>
                  @endif
                  <th>Tipo</th>
                  <th>Periodo</th>
                  <th>Subida por</th>
                  <th>Fecha de subida</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($boletas as $boleta)
                  <tr class="{{ !$boleta->confirmado_en && !$puedeGestionar ? 'fila-nueva' : '' }}">
                    @if($puedeGestionar)
                      <td>{{ $boleta->trabajador->name ?? '—' }}</td>
                    @endif
                    <td>
                      @php
                        $badgeClase = [
                          'mensual' => 'badge-info',
                          'cts' => 'badge-success',
                          'gratificacion' => 'badge-warning',
                        ][$boleta->tipo] ?? 'badge-secondary';
                      @endphp
                      <span class="badge {{ $badgeClase }}">{{ $boleta->tipo_label }}</span>
                      @if(!$boleta->confirmado_en && !$puedeGestionar)
                        <span class="badge badge-warning" title="Todavía no confirmaste que es tuya">Nueva</span>
                      @endif
                    </td>
                    <td>{{ $boleta->periodo_formateado }}</td>
                    <td>{{ $boleta->subido_por ?? '—' }}</td>
                    <td>{{ $boleta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                      <a href="{{ asset('storage/'.$boleta->archivo) }}"
                         class="btn btn-sm btn-info btn-fw mr-1"
                         title="Ver / Descargar" target="_blank">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </a>

                      @if(!$puedeGestionar && !$boleta->confirmado_en)
                        <form action="{{ route('boletas.confirmar', $boleta->id) }}" method="POST" class="d-inline">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="btn btn-sm btn-warning btn-fw mr-1" title="Confirmar que esta boleta es mía">
                            <i class="fas fa-check mr-1"></i> Confirmar que es mía
                          </button>
                        </form>
                      @endif

                      @if($puedeGestionar)
                        <form action="{{ route('boletas.destroy', $boleta->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta boleta?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger btn-fw" title="Eliminar">
                            <i class="fas fa-trash mr-1"></i> Eliminar
                          </button>
                        </form>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="{{ $puedeGestionar ? 6 : 5 }}">
                      <div class="empty-state">
                        <i class="fas fa-file-invoice-dollar"></i>
                        {{ $puedeGestionar ? 'No hay boletas registradas todavía.' : 'Todavía no tienes boletas de pago registradas.' }}
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

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

@if($puedeGestionar)
<!-- ========== Modal Subir Boleta ========== -->
<div class="modal fade" id="modalSubirBoleta" tabindex="-1" role="dialog" aria-labelledby="modalSubirBoletaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('boletas.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalSubirBoletaLabel" style="color:#1e293b;">
            <i class="fas fa-file-invoice-dollar mr-1" style="color:var(--brand-accent);"></i> Subir Boleta de Pago
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Trabajador</label>
            <select name="user_id" class="form-control shadow-sm" required>
              <option value="">Seleccione un trabajador</option>
              @foreach($trabajadores as $t)
                <option value="{{ $t->id }}">{{ $t->name }} @if($t->cargo) — {{ $t->cargo }} @endif</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>Tipo de boleta</label>
            <select name="tipo" id="tipoBoleta" class="form-control shadow-sm" required>
              <option value="mensual">Mensual</option>
              <option value="cts">CTS</option>
              <option value="gratificacion">Gratificación</option>
            </select>
          </div>

          <div class="mb-3" id="grupoPeriodoMensual">
            <label>Periodo (mes de la boleta)</label>
            <input type="month" name="periodo" class="form-control shadow-sm" value="{{ date('Y-m') }}">
          </div>

          <div class="mb-3 d-none" id="grupoPeriodoFijo">
            <label id="labelPeriodoFijo">Periodo</label>
            <div class="form-row">
              <div class="col-6">
                <select name="mes_fijo" id="mesFijo" class="form-control shadow-sm"></select>
              </div>
              <div class="col-6">
                <select name="anio" id="anioFijo" class="form-control shadow-sm"></select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label>Archivo de la boleta (PDF o imagen)</label>
            <input type="file" name="archivo" class="form-control shadow-sm" accept=".pdf,image/*" required>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-brand btn-fw">
            <i class="fas fa-upload mr-1"></i> Subir Boleta
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endif

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

@if($puedeGestionar)
<script>
  $(function () {
    var mesesPorTipo = {
      cts: [['05', 'Mayo'], ['11', 'Noviembre']],
      gratificacion: [['07', 'Julio'], ['12', 'Diciembre']]
    };

    var $tipo = $('#tipoBoleta');
    var $grupoMensual = $('#grupoPeriodoMensual');
    var $grupoFijo = $('#grupoPeriodoFijo');
    var $periodoMensual = $grupoMensual.find('input[name="periodo"]');
    var $mesFijo = $('#mesFijo');
    var $anioFijo = $('#anioFijo');

    function poblarAnios() {
      var actual = new Date().getFullYear();
      $anioFijo.empty();
      for (var a = actual + 1; a >= actual - 3; a--) {
        $anioFijo.append($('<option>').val(a).text(a));
      }
      $anioFijo.val(actual);
    }

    function actualizarFormulario() {
      var tipo = $tipo.val();

      if (tipo === 'mensual') {
        $grupoMensual.removeClass('d-none');
        $grupoFijo.addClass('d-none');
        $periodoMensual.prop('required', true);
        $mesFijo.prop('required', false);
        $anioFijo.prop('required', false);
        return;
      }

      $grupoMensual.addClass('d-none');
      $grupoFijo.removeClass('d-none');
      $periodoMensual.prop('required', false);
      $mesFijo.prop('required', true);
      $anioFijo.prop('required', true);

      $mesFijo.empty();
      (mesesPorTipo[tipo] || []).forEach(function (par) {
        $mesFijo.append($('<option>').val(par[0]).text(par[1]));
      });

      poblarAnios();
    }

    $tipo.on('change', actualizarFormulario);
    actualizarFormulario();
  });
</script>
@endif

<script>
  $(function () {
    $('#tablaBoletas').DataTable({
      responsive: true,
      autoWidth: false,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay boletas registradas."
      },
      columnDefs: [{ orderable: false, targets: -1 }],
      pageLength: 10
    });
  });
</script>

</body>
</html>
