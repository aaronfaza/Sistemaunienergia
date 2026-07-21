<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control y Seguimiento Cartas FIS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

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

    /* ===== Contenedores y utilidades de layout (KPIs) ===== */
    .dashboard-safe-container{ padding-left:clamp(16px,4vw,36px); padding-right:clamp(16px,4vw,36px); }
    @media (min-width: 992px){ .stat-row-lg-nowrap{ flex-wrap:nowrap!important; } }

    .card-clean{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-clean .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }
    .card{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }

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

    .filters-row{ background:var(--surface); border:1px solid var(--border); border-radius:4px; padding:.75rem 1rem; }

    .modal-content{ border-radius:4px!important; box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .modal-header, .modal-footer{ border-color:var(--border); }

    .form-control, .custom-select, textarea{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus, textarea:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    .empty-state{ padding:2rem 1rem; text-align:center; color:var(--text-secondary); }
    .empty-state i{ font-size:1.8rem; color:var(--border-strong); display:block; margin-bottom:.5rem; }

    .badge{ font-weight:600; padding:.3rem .5rem; border-radius:3px; font-size:.72rem; }
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

<div class="content-wrapper p-4">
<div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0" style="color:var(--text-primary); font-size:1.35rem; font-weight:700;">
            CONTROL Y SEGUIMIENTO DE ORDENES LOGISTICA LOTE IX
          </h1>
          <div style="font-size:.88rem;color:var(--text-secondary);">Gestión y seguimiento interno</div>
        </div>
        <button class="btn btn-brand btn-fw" data-toggle="modal" data-target="#modalAgregarLote">
                <i class="fas fa-plus mr-1"></i> Nuevo Registro
        </button>
      </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3" style="border-radius:4px;border-left:3px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-1" style="color:var(--brand-accent);"></i> {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-safe-container mt-3">
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
            <div class="stat-card is-warning">
                <div class="stat-icon">
                    <i class="fas fa-spinner fa-spin"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalProceso }}</span>
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
                        <span>{{ $totalFinalizados }}</span>
                    </div>
                    <span class="stat-label">Finalizados</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="stat-card is-info">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-meta">
                    <div class="stat-kpi">
                        <span>{{ $totalRegistros > 0 ? round(($totalFinalizados / $totalRegistros) * 100) : 0 }}%</span>
                    </div>
                    <span class="stat-label">Efectividad</span>
                </div>
            </div>
        </div>

    </div>
</div>



    <section class="content mt-4">
        <div class="container-fluid">
            <div class="filters-row mb-3">
                <form action="{{ route('logistica_lotes.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Buscar por código, responsable o asunto..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            @if(request('search'))
                                <a href="{{ route('logistica_lotes.index') }}" class="btn btn-secondary">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="card card-clean">
                <div class="card-body p-0"> <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cod. Log</th>
                                    <th>Carpeta</th>
                                    <th>Responsable</th>
                                    <th>N° Carta</th>
                                    <th>Asunto</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lotes as $index => $lote)
                                    <tr>
                                        <td>{{ $lotes->firstItem() + $index }}</td>
                                        <td class="font-weight-bold">{{ $lote->cod_log }}</td>
                                        <td>{{ $lote->carpeta }}</td>
                                        <td>{{ $lote->responsable }}</td>
                                        <td>{{ $lote->numero_carta }}</td>
                                        <td><small>{{ Str::limit($lote->asunto, 40) }}</small></td>
                                       <td class="text-center">
                                            <select class="form-control form-control-sm cambio-estado-rapido select-estado-{{ $lote->id }}" 
                                                    data-id="{{ $lote->id }}"
                                                    style="border-radius: 3px; font-weight: bold; font-size: 0.85rem; border: none; padding: 2px 10px;
                                                        background-color: {{ $lote->estado == 'Finalizado' ? '#d1fae5' : ($lote->estado == 'Proceso' ? '#fef3c7' : '#fee2e2') }};
                                                        color: {{ $lote->estado == 'Finalizado' ? '#047857' : ($lote->estado == 'Proceso' ? '#b45309' : '#b91c1c') }};">
                                                <option value="Pendiente" {{ $lote->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="Proceso" {{ $lote->estado == 'Proceso' ? 'selected' : '' }}>Proceso</option>
                                                <option value="Finalizado" {{ $lote->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditarLote{{ $lote->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-info mr-1" data-toggle="modal" data-target="#modalVerLote{{ $lote->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No se encontraron registros de logística.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <p class="text-muted small">
                            Mostrando del {{ $lotes->firstItem() }} al {{ $lotes->lastItem() }} 
                            de un total de {{ $lotes->total() }} registros.
                        </p>
                        </table>
                        
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $lotes->links() }}
            </div>
        </div>
    </section>
    <a href="{{ route('logistica.export') }}" class="btn btn-success btn-fw">
        <i class="fas fa-file-excel mr-2"></i> Exportar Backup Excel
    </a>
</div>



<div class="modal fade" id="modalAgregarLote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title" style="color:var(--text-primary);"><i class="fas fa-boxes mr-2" style="color:var(--brand-primary);"></i> Nuevo Registro de Logística</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('logistica_lotes.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Cod. Logística</strong></label>
                            <input type="text" class="form-control border-primary" name="cod_log" required placeholder="Ej: LOG-001">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Carpeta</strong></label>
                            <input type="text" class="form-control" name="carpeta">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Responsable</strong></label>
                            <input type="text" class="form-control" name="responsable">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Estado</strong></label>
                            <select class="form-control custom-select border-info" name="estado">
                                <option value="Pendiente">Pendiente</option>
                                <option value="Proceso">Proceso</option>
                                <option value="Finalizado">Finalizado</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label><strong>Número de Carta</strong></label>
                            <input type="text" class="form-control" name="numero_carta">
                        </div>
                        <div class="col-md-8 form-group">
                            <label><strong>Asunto</strong></label>
                            <input type="text" class="form-control" name="asunto">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Emisión</strong></label>
                            <input type="date" class="form-control" name="fecha_emision">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Código Único</strong></label>
                            <input type="text" class="form-control" name="codigo_unico">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><strong>Atención</strong></label>
                            <input type="text" class="form-control" name="atencion">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-file-invoice-dollar mr-2"></i> Datos Comerciales y Ganador</h6>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>RUC</strong></label>
                            <input type="text" class="form-control" name="ruc" maxlength="11">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><strong>Empresa Ganadora</strong></label>
                            <input type="text" class="form-control" name="empresa_ganadora">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Centro de Costo</strong></label>
                            <input type="text" class="form-control" name="centro_costo">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 form-group">
                            <label><strong>Moneda</strong></label>
                            <select class="form-control custom-select" name="moneda">
                                <option value="Soles">Soles (S/)</option>
                                <option value="Dólares">Dólares ($)</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Monto + IGV</strong></label>
                            <input type="number" step="0.01" class="form-control" name="monto_igv">
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Forma de Pago</strong></label>
                            <input type="text" class="form-control" name="forma_pago">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Tipo Solicitud</strong></label>
                            <input type="text" class="form-control" name="tipo_solicitud">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-success font-weight-bold mb-3"><i class="fas fa-tasks mr-2"></i> Documentación y Seguimiento</h6>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>N° OC / OS</strong></label>
                            <input type="text" class="form-control" name="nro_oc_os">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Emisión OC/OS</strong></label>
                            <input type="date" class="form-control" name="emision_oc_os">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Conformidad</strong></label>
                            <input type="text" class="form-control" name="conformidad" placeholder="Nro de Conformidad">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Factura</strong></label>
                            <input type="text" class="form-control" name="factura">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Entrega</strong></label>
                            <input type="date" class="form-control" name="fecha_entrega">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Orden Firmada</strong></label>
                            <select class="form-control custom-select" name="orden_firmada">
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>% Ejecución</strong></label>
                            <input type="number" class="form-control" name="porcentaje_ejecucion" placeholder="0 - 100">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Venc.</strong></label>
                            <input type="date" class="form-control" name="fecha_vencimiento">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label><strong>Observación</strong></label>
                        <textarea class="form-control" name="observacion" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-brand btn-fw px-4">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($lotes as $lote)
<div class="modal fade" id="modalEditarLote{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white border-bottom">
                <h5 class="modal-title font-weight-bold" style="color:var(--brand-warning);"><i class="fas fa-edit mr-2"></i> Editar Registro: {{ $lote->cod_log }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('logistica_lotes.update', $lote->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Cod. Logística</strong></label>
                            <input type="text" class="form-control border-warning" name="cod_log" value="{{ $lote->cod_log }}" required>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Carpeta</strong></label>
                            <input type="text" class="form-control" name="carpeta" value="{{ $lote->carpeta }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Responsable</strong></label>
                            <input type="text" class="form-control" name="responsable" value="{{ $lote->responsable }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Estado</strong></label>
                            <select class="form-control custom-select border-warning" name="estado">
                                <option value="Pendiente" {{ $lote->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Proceso" {{ $lote->estado == 'Proceso' ? 'selected' : '' }}>Proceso</option>
                                <option value="Finalizado" {{ $lote->estado == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label><strong>Número de Carta</strong></label>
                            <input type="text" class="form-control" name="numero_carta" value="{{ $lote->numero_carta }}">
                        </div>
                        <div class="col-md-8 form-group">
                            <label><strong>Asunto</strong></label>
                            <input type="text" class="form-control" name="asunto" value="{{ $lote->asunto }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Emisión</strong></label>
                            <input type="date" class="form-control" name="fecha_emision" value="{{ $lote->fecha_emision }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Código Único</strong></label>
                            <input type="text" class="form-control" name="codigo_unico" value="{{ $lote->codigo_unico }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><strong>Atención</strong></label>
                            <input type="text" class="form-control" name="atencion" value="{{ $lote->atencion }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-file-invoice-dollar mr-2"></i> Datos Comerciales y Ganador</h6>
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
                                <option value="Soles" {{ $lote->moneda == 'Soles' ? 'selected' : '' }}>Soles (S/)</option>
                                <option value="Dólares" {{ $lote->moneda == 'Dólares' ? 'selected' : '' }}>Dólares ($)</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Monto + IGV</strong></label>
                            <input type="number" step="0.01" class="form-control" name="monto_igv" value="{{ $lote->monto_igv }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label><strong>Forma de Pago</strong></label>
                            <input type="text" class="form-control" name="forma_pago" value="{{ $lote->forma_pago }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Tipo Solicitud</strong></label>
                            <input type="text" class="form-control" name="tipo_solicitud" value="{{ $lote->tipo_solicitud }}">
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-success font-weight-bold mb-3"><i class="fas fa-tasks mr-2"></i> Documentación y Seguimiento</h6>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>N° OC / OS</strong></label>
                            <input type="text" class="form-control" name="nro_oc_os" value="{{ $lote->nro_oc_os }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Emisión OC/OS</strong></label>
                            <input type="date" class="form-control" name="emision_oc_os" value="{{ $lote->emision_oc_os }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Conformidad</strong></label>
                            <input type="text" class="form-control" name="conformidad" value="{{ $lote->conformidad }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Factura</strong></label>
                            <input type="text" class="form-control" name="factura" value="{{ $lote->factura }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Entrega</strong></label>
                            <input type="date" class="form-control" name="fecha_entrega" value="{{ $lote->fecha_entrega }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Orden Firmada</strong></label>
                            <select class="form-control custom-select" name="orden_firmada">
                                <option value="0" {{ $lote->orden_firmada == 0 ? 'selected' : '' }}>NO</option>
                                <option value="1" {{ $lote->orden_firmada == 1 ? 'selected' : '' }}>SI</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>% Ejecución</strong></label>
                            <input type="number" class="form-control" name="porcentaje_ejecucion" value="{{ $lote->porcentaje_ejecucion }}">
                        </div>
                        <div class="col-md-3 form-group">
                            <label><strong>Fecha Venc.</strong></label>
                            <input type="date" class="form-control" name="fecha_vencimiento" value="{{ $lote->fecha_vencimiento }}">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label><strong>Observación</strong></label>
                        <textarea class="form-control" name="observacion" rows="2">{{ $lote->observacion }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning btn-fw px-4">Actualizar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>












<div class="modal fade" id="modalVerLote{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-white border-bottom d-flex align-items-center">
                <h5 class="modal-title font-weight-bold" style="color:var(--brand-primary);">
                    <i class="fas fa-file-invoice mr-2"></i> DETALLE DEL REGISTRO: {{ $lote->cod_log }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-4 p-3" style="background:var(--page-bg);border:1px solid var(--border);border-radius:4px;">
                    <div class="col-md-4">
                        <small class="text-uppercase text-muted d-block">Estado</small>
                        <span class="badge p-2 px-3 {{ $lote->estado == 'Finalizado' ? 'bg-success text-white' : ($lote->estado == 'Proceso' ? 'bg-warning' : 'bg-danger text-white') }}">
                            {{ $lote->estado }}
                        </span>
                    </div>
                    <div class="col-md-4 text-center">
                        <small class="text-uppercase text-muted d-block">Progreso</small>
                        <div class="progress mt-1" style="height: 14px; border-radius: 3px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $lote->porcentaje_ejecucion }}%;" aria-valuenow="{{ $lote->porcentaje_ejecucion }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $lote->porcentaje_ejecucion }}%
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
                        <p class="font-weight-bold">{{ $lote->carpeta }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Responsable</label>
                        <p class="font-weight-bold">{{ $lote->responsable }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Fecha Emisión</label>
                        <p class="font-weight-bold">{{ $lote->fecha_emision ? \Carbon\Carbon::parse($lote->fecha_emision)->format('d/m/Y') : '-' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Número de Carta</label>
                        <p class="font-weight-bold text-primary">{{ $lote->numero_carta }}</p>
                    </div>
                    <div class="col-md-8">
                        <label class="text-muted small mb-0">Asunto</label>
                        <p class="font-weight-bold">{{ $lote->asunto }}</p>
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
                        <p class="font-weight-bold">{{ $lote->moneda }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Monto IGV</label>
                        <p class="font-weight-bold">{{ number_format($lote->monto_igv, 2) }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">N° Factura</label>
                        <p class="font-weight-bold">{{ $lote->factura ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Monto Factura</label>
                        <p class="font-weight-bold">{{ number_format($lote->monto_factura, 2) }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">F. Vencimiento</label>
                        <p class="font-weight-bold text-danger">{{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-muted small mb-0">Forma de Pago</label>
                        <p class="font-weight-bold">{{ $lote->forma_pago }}</p>
                    </div>
                </div>

                <h6 class="text-primary font-weight-bold border-bottom pb-2 mb-3"><i class="fas fa-truck mr-2"></i> Seguimiento y Conformidad</h6>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Conformidad</label>
                        <p class="font-weight-bold">{{ $lote->conformidad ?? 'Pendiente' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small mb-0">Fecha Entrega</label>
                        <p class="font-weight-bold">{{ $lote->fecha_entrega ? \Carbon\Carbon::parse($lote->fecha_entrega)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="col-md-4">
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

                <div class="p-3" style="background:var(--page-bg);border-left:3px solid var(--brand-info);border-radius:3px;">
                    <label class="text-muted small mb-1">Observaciones</label>
                    <p class="mb-0 italic">{{ $lote->observacion ?? 'Sin observaciones registradas.' }}</p>
                </div>
            </div>

            <div class="modal-footer bg-light justify-content-between">
                <div class="small text-muted">
                    Creado: {{ $lote->created_at->format('d/m/Y H:i') }}
                </div>
                <div>
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cerrar</button>
                    <a href="{{ route('logistica_lotes.pdf', $lote->id) }}" class="btn btn-danger btn-fw px-4">
                        <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>





@endforeach



<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>
<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display:none;">
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
$(document).on('change', '.cambio-estado-rapido', function() {
    let loteId = $(this).data('id');
    let nuevoEstado = $(this).val();
    let select = $(this);

    // Colores dinámicos para el feedback visual
    const colores = {
        'Finalizado': { bg: '#d1fae5', text: '#047857' },
        'Proceso': { bg: '#fef3c7', text: '#b45309' },
        'Pendiente': { bg: '#fee2e2', text: '#b91c1c' }
    };

    $.ajax({
        url: "{{ url('logistica_lotes') }}/" + loteId + "/actualizar-estado",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            estado: nuevoEstado
        },
        success: function(response) {
            // Actualizar colores del select instantáneamente
            select.css({
                'background-color': colores[nuevoEstado].bg,
                'color': colores[nuevoEstado].text
            });
            
            // Notificación pequeña (Toast)
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
</script>
<script>
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });
</script>

</body>
</html>
