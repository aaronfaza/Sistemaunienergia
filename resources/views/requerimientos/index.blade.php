<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Requerimientos - Sistema Integrado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- DataTables (Bootstrap 4 + Responsive) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

  <style>
    /* ===== Paleta corporativa sobria — sin gradientes, sin tonos oscuros de fondo ===== */
    :root{
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

    .no-resize { resize: none !important; }
    .tall-textarea { min-height: 70px; }

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
    .sidebar-user-footer .avatar{ width:34px; height:34px; border-radius:2px; object-fit:cover; flex-shrink:0; }
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
    .btn-info, .btn-outline-info{ background:var(--surface); border:1px solid var(--brand-info); color:var(--brand-info); }
    .btn-info:hover, .btn-outline-info:hover{ background:#ECFAFB; color:var(--brand-info); }
    .btn-warning{ background:var(--surface); border:1px solid #F5D08A; color:var(--brand-warning); }
    .btn-warning:hover{ background:#FFFBEB; color:var(--brand-warning); }
    .btn-danger, .btn-outline-danger{ background:var(--surface); border:1px solid #F3C6C6; color:var(--brand-danger); }
    .btn-danger:hover, .btn-outline-danger:hover{ background:#FEF2F2; color:var(--brand-danger); }
    .btn-success{ background:var(--surface); border:1px solid #A7D7BB; color:var(--brand-accent); }
    .btn-success:hover{ background:#EEF7F1; color:var(--brand-accent); }
    .btn-outline-brand{ background:var(--surface); border:1px solid var(--brand-primary); color:var(--brand-primary); }
    .btn-outline-brand:hover{ background:#EEF1F5; color:var(--brand-primary); }
    .btn-outline-secondary{ border-radius:3px!important; }
    .btn-fw{ font-weight:600; }

    /* ===== KPI cards — planas, con borde, sin sombra ===== */
    .stat-row{ margin-left:-8px; margin-right:-8px; }
    .stat-row > [class*="col-"]{ padding-left:8px; padding-right:8px; }
    .stat-card{
      display:flex; align-items:center; gap:12px;
      padding:12px 14px; border-radius:4px; min-height:76px;
      background:var(--surface); border:1px solid var(--border); border-left:3px solid var(--border-strong);
    }
    .stat-card.is-primary{ border-left-color:var(--brand-primary); }
    .stat-card.is-info{ border-left-color:var(--brand-info); }
    .stat-card.is-success{ border-left-color:var(--brand-accent); }
    .stat-card.is-warning{ border-left-color:var(--brand-warning); }
    .stat-icon{ width:34px; height:34px; border-radius:3px; display:grid; place-items:center; flex-shrink:0; background:var(--page-bg); }
    .stat-icon i{ font-size:16px; }
    .is-primary .stat-icon{ color:var(--brand-primary); }
    .is-info .stat-icon{ color:var(--brand-info); }
    .is-success .stat-icon{ color:var(--brand-accent); }
    .is-warning .stat-icon{ color:var(--brand-warning); }
    .stat-meta{ display:flex; flex-direction:column; color:var(--text-primary); }
    .stat-kpi span{ font-weight:700; font-size:clamp(18px,2.4vw,22px); line-height:1.1; }
    .stat-label{ font-size:.78rem; color:var(--text-secondary); }

    /* ===== Tabla — densa, tipo hoja de datos empresarial ===== */
    table thead th{
      background:#F3F4F6!important; border:1px solid var(--border)!important; font-size:.72rem;
      text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); padding:.55rem .7rem; white-space:nowrap;
    }
    table tbody tr{ background:var(--surface); }
    table tbody tr:hover{ background:#F8FAFC; }
    table tbody td{ border:1px solid var(--border)!important; vertical-align:middle; padding:.55rem .7rem; font-size:.86rem; color:var(--text-primary); }

    #tablaRequerimientos{ border-collapse:collapse!important; }
    @media (max-width:576px){
      #tablaRequerimientos td:nth-child(3),
      #tablaRequerimientos td:nth-child(4){ white-space: normal; }
    }

    .actions-wrap{ display:inline-flex; gap:.35rem; flex-wrap:wrap; justify-content:center; }

    .filters-row{ background:var(--surface); border:1px solid var(--border); border-radius:4px; padding:.75rem 1rem; }

    .modal-content{ border-radius:4px!important; box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .modal-header, .modal-footer{ border-color:var(--border); }

    .form-control, .custom-select{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    .input-group-text{ border-radius:3px; border-color:var(--border-strong); background:var(--page-bg); color:var(--text-secondary); font-size:.85rem; }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    .empty-state{ padding:2rem 1rem; text-align:center; color:var(--text-secondary); }
    .empty-state i{ font-size:1.8rem; color:var(--border-strong); display:block; margin-bottom:.5rem; }

    .badge{ font-weight:600; padding:.3rem .5rem; border-radius:3px; font-size:.72rem; }

    /* ===== Modal Nuevo Requerimiento ===== */
    #modalAgregar .form-section{
      background:var(--surface); border:1px solid var(--border);
      border-radius:4px; margin-bottom:.85rem; padding:1rem;
    }
    #wrapTablaDetalles{ overflow-x:auto; -webkit-overflow-scrolling:touch; }
    #tablaDetalles thead th{
      background:#F3F4F6; border:1px solid var(--border)!important; font-size:.72rem;
      text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); padding:.5rem .6rem;
    }
    #tablaDetalles tbody td{ border:1px solid var(--border)!important; vertical-align:middle; padding:.4rem .5rem; }
    .table-items tbody tr:hover{ background:#F8FAFC; }

    @media (max-width: 576px) {
      #modalAgregar .modal-dialog{
        width:100%!important; max-width:100%!important; margin:0!important;
        height:100%!important; display:flex; flex-direction:column;
      }
      #modalAgregar .modal-content{
        border-radius:0!important; height:100vh!important; display:flex; flex-direction:column;
      }
      #modalAgregar .modal-header{ position:sticky; top:0; z-index:3; background:var(--surface); }
      #modalAgregar .modal-footer{ position:sticky; bottom:0; z-index:3; background:var(--surface); }
      #modalAgregar .modal-body{
        overflow-y:auto; -webkit-overflow-scrolling:touch;
        padding: 1rem .75rem 4.5rem;
      }
      #modalAgregar .btn{ padding:.6rem .85rem; }
      #modalAgregar .input-group-text{ min-width:2.5rem; justify-content:center; }
    }
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
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-flex align-items-center ml-2">
          <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width:22px;height:22px;">
        </li>
      </ul>

      <ul class="navbar-nav ml-auto d-flex align-items-center">
        <!-- Notificaciones -->
        <li class="nav-item dropdown mr-2">
          <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell text-white"></i>
            @if($notificaciones->count() > 0)
              <span id="notiBadge" class="badge badge-danger position-absolute" style="top:-2px;right:-6px;font-size:.6rem;">
                {{ $notificaciones->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border" aria-labelledby="notificacionesDropdown" style="min-width:300px;max-height:380px;overflow-y:auto;border-radius:4px;">
            <h6 class="dropdown-header font-weight-bold text-dark"><i class="fas fa-bell mr-1"></i> Últimos registros</h6>
            <div class="dropdown-divider"></div>
            @forelse($notificaciones as $notificacion)
              <div class="dropdown-item">
                <div class="d-flex flex-column">
                  <span class="font-weight-bold" style="color:var(--brand-primary);">{{ $notificacion->titulo ?? ('Requerimiento '.$notificacion->codigo) }}</span>
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
                <p>Fis</p>
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
      <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="m-0" style="color:var(--text-primary);font-size:1.4rem;font-weight:700;">
          <i class="fas fa-file-alt mr-2" style="color:var(--brand-primary);"></i>Requerimientos, Operaciones Lote IX
        </h1>
        <button class="btn btn-brand btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalAgregar">
          <i class="fas fa-plus mr-1"></i> Nuevo Requerimiento
        </button>
      </div>
    </div>

    <div class="container-fluid pt-3">

      <!-- KPI -->
      <div class="row stat-row mb-3">
        <div class="col-12 col-sm-6 col-md-4 mb-3 mb-md-0">
          <div class="stat-card is-primary">
            <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
            <div class="stat-meta">
              <div class="stat-kpi"><span>{{ $total }}</span></div>
              <div class="stat-label">Total de requerimientos</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-3 mb-md-0">
          <div class="stat-card is-info">
            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-meta">
              <div class="stat-kpi"><span>{{ $esteMes }}</span></div>
              <div class="stat-label">Registrados este mes</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="stat-card is-success">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-meta">
              <div class="stat-kpi"><span>{{ $hoy }}</span></div>
              <div class="stat-label">Registrados hoy</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla -->
      <div class="card card-clean">
        <div class="card-header">
          <h3 class="card-title mb-0" style="color:var(--text-primary);font-size:1rem;">
            <i class="fas fa-list mr-1" style="color:var(--brand-primary);"></i> Lista de Requerimientos
          </h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tablaRequerimientos" class="table table-hover table-bordered align-middle text-center" style="width:100%">
              <thead>
                <tr>
                  <th data-priority="1">Código</th>
                  <th data-priority="3">Fecha</th>
                  <th data-priority="4">Área solicitante</th>
                  <th data-priority="5">Solicitante</th>
                  <th data-priority="6">Tipo</th>
                  <th data-priority="2">Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($requerimientos as $req)
                  <tr>
                    <td>{{ $req->codigo }}</td>
                    <td>{{ \Carbon\Carbon::parse($req->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $req->area_solicitante }}</td>
                    <td>{{ $req->nombre_solicitante }}</td>
                    <td>{{ $req->servicio }}</td>
                    <td>
                      <span class="actions-wrap">
                        <a href="{{ route('requerimientos.show', $req->id) }}"
                           class="btn btn-sm btn-outline-info"
                           title="Ver (PDF)"
                           target="_blank"
                           rel="noopener noreferrer">
                          <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('requerimientos.destroy', $req->id) }}" method="POST" class="d-inline-block"
                              onsubmit="return confirm('¿Eliminar el requerimiento {{ $req->codigo }}? Esta acción no se puede deshacer.');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </span>
                    </td>
                  </tr>
                @empty
                  {{-- DataTables mostrará "emptyTable" --}}
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="px-3 py-2 text-right">
            <span class="text-muted">Total de requerimientos en página: <strong>{{ $requerimientos->count() }}</strong></span>
          </div>
          <div class="d-flex flex-wrap justify-content-between align-items-center mt-3 pt-3" style="border-top:1px solid var(--border);">
            <h5 class="mb-2 mb-md-0" style="font-size:.95rem;font-weight:600;color:var(--text-primary);">
              <i class="fas fa-file-export mr-2" style="color:var(--brand-primary);"></i> Realizar Backup
            </h5>
            <div class="d-flex flex-wrap" style="gap:.5rem;">
              <a href="{{ route('requerimientos.export.excel') }}" class="btn btn-success btn-fw">
                <i class="fas fa-file-excel mr-1"></i> Excel
              </a>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->

  </div><!-- /.content-wrapper -->

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

<!-- ===== Modal Crear Requerimiento ===== -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <form method="POST" action="{{ route('requerimientos.store') }}" id="formCrearReq" novalidate>
      @csrf
      <div class="modal-content" id="modalAgregarContent">
        <div class="modal-header bg-white border-bottom">
          <div class="d-flex flex-column">
            <h5 class="modal-title font-weight-semibold mb-0" id="modalAgregarLabel">
              <i class="fas fa-file-alt mr-1" style="color:var(--brand-primary);"></i> Nuevo Requerimiento
            </h5>
            <small class="text-muted">Complete los campos y añada los ítems necesarios</small>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <!-- Sección: Datos generales -->
          <div class="form-section">
            <div class="form-row">
              <div class="col-12 col-md-4 mb-3">
                <label for="codigo_modal" class="mb-1">Código</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
                  <input type="text" id="codigo_modal" name="codigo" class="form-control" value="{{ old('codigo') }}" required>
                </div>
                @error('codigo') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-6 col-md-4 mb-3">
                <label for="fecha_modal" class="mb-1">Fecha</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                  <input type="date" id="fecha_modal" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                </div>
                @error('fecha') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-6 col-md-4 mb-3">
                <label for="area_solicitante_modal" class="mb-1">Área solicitante</label>
                @php
                  $areas = ['Ingenieria de Produccion y Facilidades','HSE','Administracion','Logistica','Mantenimiento','Produccion'];
                  $areaActual = old('area_solicitante','');
                @endphp
                <select name="area_solicitante" id="area_solicitante_modal" class="form-control" required>
                  <option value="" disabled {{ $areaActual==='' ? 'selected' : '' }}>Seleccione…</option>
                  @foreach($areas as $area)
                    <option value="{{ $area }}" {{ $areaActual === $area ? 'selected' : '' }}>{{ $area }}</option>
                  @endforeach
                </select>
                @error('area_solicitante') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="nombre_solicitante_modal" class="mb-1">Nombre solicitante</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                  <input type="text" id="nombre_solicitante_modal" name="nombre_solicitante" class="form-control"
                         value="{{ old('nombre_solicitante', Auth::user()->name ?? '') }}" readonly required>
                </div>
                @error('nombre_solicitante') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="cargo_solicitante" class="mb-1">Cargo</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" id="cargo_solicitante" name="cargo_solicitante" class="form-control"
                        value="{{ Auth::user()->cargo ?? '' }}" readonly required>
                </div>
                @error('cargo_solicitante')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label class="d-block mb-1">Destino</label>
                @php
                  $opDestinos = ['Lote IX','Oficina','Unidad vehicular','Vivienda'];
                  $seleccionados = old('destino', []);
                @endphp
                @foreach ($opDestinos as $i => $opt)
                  <div class="custom-control custom-checkbox custom-control-inline mb-1">
                    <input class="custom-control-input" type="checkbox" id="destino_{{ $i }}" name="destino[]" value="{{ $opt }}"
                           {{ in_array($opt, (array)$seleccionados) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="destino_{{ $i }}">{{ $opt }}@if(in_array($opt,['Lote IX','Unidad vehicular','Vivienda']))*@endif</label>
                  </div>
                @endforeach
                @error('destino') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="servicio_modal" class="mb-1">Requerimiento de</label>
                @php
                  $opciones = ['Compra','Servicio'];
                  $valorActual = old('servicio', '');
                @endphp
                <select name="servicio" id="servicio_modal" class="form-control" required>
                  <option value="" disabled {{ $valorActual==='' ? 'selected' : '' }}>Seleccione…</option>
                  @foreach ($opciones as $opt)
                    <option value="{{ $opt }}" {{ $valorActual === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                  @endforeach
                </select>
                @error('servicio') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 mb-2">
                <label for="sustento" class="mb-1">Sustento</label>
                <textarea
                  id="sustento"
                  name="sustento"
                  class="form-control no-resize tall-textarea"
                  placeholder="Detalle breve del requerimiento..."
                >{{ old('sustento') }}</textarea>
                @error('sustento') <small class="text-danger d-block">{{ $message }}</small> @enderror
                <small class="form-text text-muted">Sea claro y conciso. Puede adjuntar detalles en los ítems.</small>
              </div>
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          </div>

          <!-- Sección: Ítems -->
          <div class="form-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
              <h6 class="mb-2 mb-sm-0">Ítems del requerimiento</h6>
              <div class="btn-group btn-group-sm" role="group" aria-label="Acciones ítems">
                <button type="button" id="btnAddItem" class="btn btn-outline-brand">
                  <i class="fas fa-plus mr-1"></i> Agregar ítem
                </button>
                <button type="button" id="btnClearItems" class="btn btn-outline-secondary">
                  <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
              </div>
            </div>

            <div id="wrapTablaDetalles" class="table-responsive">
              <table class="table table-sm table-bordered align-middle table-items" id="tablaDetalles">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th style="min-width:160px">Identificación</th>
                    <th style="min-width:100px">Cantidad</th>
                    <th style="min-width:120px">Unidad</th>
                    <th style="min-width:220px">Descripción</th>
                    <th style="width:70px">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $oldDetalles = old('detalles', [['identificacion'=>'','cantidad'=>'','unidad'=>'','descripcion'=>'']]);
                  @endphp
                  @foreach($oldDetalles as $idx => $d)
                    <tr>
                      <td><input type="text" name="detalles[{{ $idx }}][identificacion]" class="form-control form-control-sm" value="{{ $d['identificacion'] ?? '' }}" placeholder="Código o referencia"></td>
                      <td><input type="number" min="1" name="detalles[{{ $idx }}][cantidad]" class="form-control form-control-sm" value="{{ $d['cantidad'] ?? '' }}" placeholder="1"></td>
                      <td><input type="text" name="detalles[{{ $idx }}][unidad]" class="form-control form-control-sm" value="{{ $d['unidad'] ?? '' }}" placeholder="Ej: UN, KG"></td>
                      <td><input type="text" name="detalles[{{ $idx }}][descripcion]" class="form-control form-control-sm" value="{{ $d['descripcion'] ?? '' }}" required placeholder="Descripción del ítem"></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" data-toggle="tooltip" title="Eliminar fila">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @error('detalles') <small class="text-danger d-block">{{ $message }}</small> @enderror
            @error('detalles.*.descripcion') <small class="text-danger d-block">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="modal-footer bg-white">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-brand">
            <i class="fas fa-save mr-1"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ===== Scripts (orden correcto) ===== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- DataTables + Responsive (Bootstrap 4) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
  // Notificaciones: ocultar badge al abrir
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });

  // DataTable Responsive con prioridades
  $(function(){
    $('#tablaRequerimientos').DataTable({
      responsive: { details: { type: 'inline', target: 'tr' } },
      autoWidth: false,
      columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 },
        { responsivePriority: 3, targets: 1 },
        { responsivePriority: 4, targets: 2 },
        { responsivePriority: 5, targets: 3 },
        { responsivePriority: 6, targets: 4 },
      ],
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay requerimientos registrados."
      }
    });
  });

  // ===== JS del modal =====
  (function () {
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Autogrow Sustento
    var ta = document.getElementById('sustento');
    if (ta) {
      function autogrow(el){ el.style.height='auto'; el.style.height=(el.scrollHeight+2)+'px'; }
      ta.addEventListener('input', function(){ autogrow(ta); });
      setTimeout(function(){ autogrow(ta); }, 100);
    }

    // Tabla dinámica de detalles
    var $tbody = $('#tablaDetalles tbody');
    var idx = $tbody.find('tr').length;

    function addRow(data) {
      data = data || {};
      var html = `
        <tr>
          <td><input type="text" name="detalles[${idx}][identificacion]" class="form-control form-control-sm" value="${data.identificacion||''}" placeholder="Código o referencia"></td>
          <td><input type="number" min="1" name="detalles[${idx}][cantidad]" class="form-control form-control-sm" value="${data.cantidad||''}" placeholder="1"></td>
          <td><input type="text" name="detalles[${idx}][unidad]" class="form-control form-control-sm" value="${data.unidad||''}" placeholder="Ej: UN, KG"></td>
          <td><input type="text" name="detalles[${idx}][descripcion]" class="form-control form-control-sm" value="${data.descripcion||''}" required placeholder="Descripción del ítem"></td>
          <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" data-toggle="tooltip" title="Eliminar fila">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>`;
      $tbody.append(html);
      idx++;
    }

    $('#btnAddItem').on('click', function(){ addRow(); });

    $('#btnClearItems').on('click', function(){
      if(confirm('¿Limpiar todas las filas de ítems?')){ $tbody.empty(); idx = 0; addRow(); }
    });

    $tbody.on('click', '.btn-del-row', function(){
      var $rows = $tbody.find('tr');
      if ($rows.length > 1) $(this).closest('tr').remove();
    });

    // Enter en descripción agrega fila
    $tbody.on('keydown', 'input[name$="[descripcion]"]', function(e){
      if (e.key === 'Enter'){ e.preventDefault(); addRow(); }
    });

    // Reabrir si hubo validaciones con error
    @if ($errors->any())
      $('#modalAgregar').modal('show');
    @endif
  })();
</script>

</body>
</html>
