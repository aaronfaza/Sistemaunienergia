<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Anomalías de Mantenimiento</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
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

    /* Botón de acción principal en rojo sobrio (reportar anomalía) — sólido, sin gradiente ni sombra */
    .btn-danger-solid{ background:var(--brand-danger); border:1px solid #8F1414; color:#fff!important; }
    .btn-danger-solid:hover{ background:#8F1414; color:#fff; }

    /* ===== Tabla — densa, tipo hoja de datos empresarial ===== */
    #tablaAnomalias{ border-collapse:collapse!important; }
    #tablaAnomalias thead th{
      background:#F3F4F6!important; border:1px solid var(--border)!important; font-size:.72rem;
      text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); padding:.55rem .7rem; white-space:nowrap;
    }
    #tablaAnomalias tbody tr{ background:var(--surface); }
    #tablaAnomalias tbody tr:hover{ background:#F8FAFC; }
    #tablaAnomalias tbody td{ border:1px solid var(--border)!important; vertical-align:middle; padding:.55rem .7rem; font-size:.86rem; color:var(--text-primary); }

    .filters-row{ background:var(--surface); border:1px solid var(--border); border-radius:4px; padding:.75rem 1rem; }

    .modal-content{ border-radius:4px!important; box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .modal-header, .modal-footer{ border-color:var(--border); }

    .form-control, .custom-select{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    .empty-state{ padding:2rem 1rem; text-align:center; color:var(--text-secondary); }
    .empty-state i{ font-size:1.8rem; color:var(--border-strong); display:block; margin-bottom:.5rem; }

    .badge{ font-weight:600; padding:.3rem .5rem; border-radius:3px; font-size:.72rem; }

    /* ===== Badges de gravedad — planos, con borde ===== */
    .gravedad-badge{ font-weight:600; padding:.3rem .6rem; border-radius:3px; font-size:.72rem; border:1px solid transparent; }
    .gravedad-Baja{ background:#F0FDF4; color:var(--brand-accent); border-color:#BBF7D0; }
    .gravedad-Media{ background:#FFFBEB; color:var(--brand-warning); border-color:#F5D08A; }
    .gravedad-Alta{ background:#FEF2F2; color:var(--brand-danger); border-color:#F3C6C6; }
    .gravedad-Crítica{ background:var(--brand-danger); color:#fff; border-color:#8F1414; }

    /* ===== Selector de estado — plano, con borde, sin píldora ===== */
    .estado-select{
      border-radius:3px; font-weight:600; font-size:.8rem; padding:4px 10px;
      border:1px solid var(--border-strong); outline:none; cursor:pointer; min-width:130px;
      text-align:center; background:var(--surface); transition:background-color .12s ease;
    }
    .estado-Pendiente{ background:#FFFBEB; color:var(--brand-warning); border-color:#F5D08A; }
    .estado-Pendiente:hover{ background:#FFF3D6; }
    .estado-EnAtencion{ background:#ECFAFB; color:var(--brand-info); border-color:#A9DEE6; }
    .estado-EnAtencion:hover{ background:#DEF4F7; }
    .estado-Resuelta{ background:#F0FDF4; color:var(--brand-accent); border-color:#BBF7D0; }
    .estado-Resuelta:hover{ background:#E1FAEA; }

    /* ===== Evidencia fotográfica — plana, sin sombras ===== */
    .photo-card{ border:1px solid var(--border); border-radius:4px; padding:12px; background:var(--surface); }
    .photo-preview{
      width:100%; height:160px; border-radius:3px; border:1px solid var(--border);
      background:var(--page-bg); display:flex; align-items:center; justify-content:center; overflow:hidden;
    }
    .photo-preview img{ width:100%; height:100%; object-fit:cover; display:block; }
    .photo-empty{ font-size:.82rem; color:var(--text-secondary); text-align:center; padding:10px; }
    .photo-meta{ font-size:.78rem; color:var(--text-secondary); margin-top:8px; line-height:1.2; }
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

  <!-- Contenido -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid">
        <h1 class="m-0" style="color:var(--text-primary);font-size:1.4rem;font-weight:700;">Anomalías de Pozos</h1>
        <h5 class="mb-0" style="margin-top:2px;font-weight:400;font-size:.88rem;color:var(--text-secondary);">Reporte de fallas en motores, unidades de bombeo y equipos de campo</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius:4px;border-left:3px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="border-radius:4px;">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
    </div>

    <div class="container-fluid pt-3">
      <div class="card card-clean mb-3">
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title m-0" style="color:var(--text-primary);font-size:1rem;">Reportar nueva anomalía</h3>
            <button class="btn btn-danger-solid btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalAgregarAnomalia">
              <i class="fas fa-exclamation-triangle mr-1"></i> Reportar Anomalía
            </button>
          </div>
        </div>
      </div>

      <div class="filters-row mb-3">
        <form action="{{ route('anomalias.index') }}" method="GET" class="form-inline">
          <div class="form-group mr-2 mb-2">
            <input type="text" name="pozo" class="form-control" placeholder="Buscar por pozo/ubicación" value="{{ request('pozo') }}">
          </div>
          <div class="form-group mr-2 mb-2">
            <select name="estado" class="form-control">
              <option value="">Todos los estados</option>
              <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
              <option value="En Atención" {{ request('estado') == 'En Atención' ? 'selected' : '' }}>En Atención</option>
              <option value="Resuelta" {{ request('estado') == 'Resuelta' ? 'selected' : '' }}>Resuelta</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-fw mb-2">
            <i class="fas fa-search mr-1"></i> Buscar
          </button>
        </form>
      </div>

      <div class="card card-clean">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
          <h3 class="card-title mb-0" style="color:var(--text-primary);font-size:1rem;">
            <i class="fas fa-exclamation-triangle mr-1" style="color:var(--brand-danger);"></i> Anomalías Reportadas
          </h3>
          <span style="color:var(--text-secondary);font-size:.85rem;">
            Total: <strong style="color:var(--text-primary);">{{ $totalAnomalias }}</strong> · Pendientes: <strong style="color:var(--brand-danger);">{{ $totalPendientes }}</strong>
          </span>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="tablaAnomalias" class="table table-hover align-middle text-center" style="width:100%;">
              <thead>
                <tr>
                  <th>Reportado por</th>
                  <th>Pozo / Ubicación</th>
                  <th>Tipo de equipo</th>
                  <th>Gravedad</th>
                  <th>Fecha</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($anomalias as $anomalia)
                  <tr>
                    <td>{{ $anomalia->nombre }}</td>
                    <td>{{ $anomalia->pozo }}</td>
                    <td>{{ $anomalia->tipo_equipo }}</td>
                    <td><span class="gravedad-badge gravedad-{{ $anomalia->gravedad }}">{{ $anomalia->gravedad }}</span></td>
                    <td>{{ $anomalia->fecha ? $anomalia->fecha->format('d/m/Y') : $anomalia->created_at->format('d/m/Y') }}</td>
                    <td>
                      @if(Auth::user()->esSoloMantenimiento())
                        <span class="estado-select
                          @if($anomalia->estado === 'Pendiente') estado-Pendiente
                          @elseif($anomalia->estado === 'En Atención') estado-EnAtencion
                          @else estado-Resuelta
                          @endif">
                          @if($anomalia->estado === 'Pendiente') 🟡 Pendiente
                          @elseif($anomalia->estado === 'En Atención') 🔵 En Atención
                          @else 🟢 Resuelta
                          @endif
                        </span>
                      @else
                        <form action="{{ route('anomalias.update_estado', $anomalia->id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <select name="estado" onchange="this.form.submit()"
                            class="estado-select
                              @if($anomalia->estado === 'Pendiente') estado-Pendiente
                              @elseif($anomalia->estado === 'En Atención') estado-EnAtencion
                              @else estado-Resuelta
                              @endif">
                            <option value="Pendiente" {{ $anomalia->estado == 'Pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                            <option value="En Atención" {{ $anomalia->estado == 'En Atención' ? 'selected' : '' }}>🔵 En Atención</option>
                            <option value="Resuelta" {{ $anomalia->estado == 'Resuelta' ? 'selected' : '' }}>🟢 Resuelta</option>
                          </select>
                        </form>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('anomalias.show', $anomalia->id) }}"
                         class="btn btn-sm btn-info btn-fw mr-1"
                         title="Ver Reporte" target="_blank">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </a>

                      @if(!Auth::user()->esSoloMantenimiento())
                        <a href="{{ route('anomalias.pdf', $anomalia->id) }}"
                           class="btn btn-sm btn-primary btn-fw mr-1"
                           title="Descargar PDF">
                          <i class="fas fa-file-pdf mr-1"></i> Descargar
                        </a>

                        <form action="{{ route('anomalias.destroy', $anomalia->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta anomalía?');">
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
                    <td colspan="7">
                      <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        No hay anomalías registradas.
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
    <strong>Unienergia ABC © 2025</strong> Todos los derechos reservados.
  </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>
<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<!-- ========== Modal Reportar Anomalía ========== -->
<div class="modal fade" id="modalAgregarAnomalia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarAnomaliaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form id="formAgregarAnomalia" method="POST" action="{{ route('anomalias.store') }}" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="modal-content border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarAnomaliaLabel" style="color:var(--text-primary);">
            <i class="fas fa-exclamation-triangle mr-1" style="color:var(--brand-danger);"></i> Reportar Anomalía en Pozo
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div id="msgFormAnomalia" class="alert alert-danger d-none"></div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Fecha de la anomalía</label>
              <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Pozo / Ubicación</label>
              <input type="text" name="pozo" class="form-control" placeholder="Ej: Pozo 14 - Batería Norte" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="tipo_equipo_anomalia">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo_anomalia" class="form-control" required>
                <option value="">Seleccione una opción</option>
                <option value="Motor">Motor</option>
                <option value="Unidad de Bombeo Mecánico">Unidad de Bombeo Mecánico</option>
                <option value="Bomba de Transferencia">Bomba de Transferencia</option>
                <option value="Caja Reductora">Caja Reductora</option>
              </select>
            </div>

            <div class="col-md-12 mb-3">
              <label>Nivel de gravedad</label>
              <div class="d-flex flex-wrap" style="gap:.75rem;">
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="gravedad_baja" name="gravedad" value="Baja" class="custom-control-input" required>
                  <label class="custom-control-label" for="gravedad_baja">🟢 Baja</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="gravedad_media" name="gravedad" value="Media" class="custom-control-input" checked>
                  <label class="custom-control-label" for="gravedad_media">🟡 Media</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="gravedad_alta" name="gravedad" value="Alta" class="custom-control-input">
                  <label class="custom-control-label" for="gravedad_alta">🟠 Alta</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" id="gravedad_critica" name="gravedad" value="Crítica" class="custom-control-input">
                  <label class="custom-control-label" for="gravedad_critica">🔴 Crítica</label>
                </div>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <label>Descripción de la anomalía</label>
              <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe qué encontraste: ruido anormal, fuga, vibración, sobrecalentamiento, etc." required></textarea>
            </div>

            <div class="col-md-12 mb-3">
              <label>Sugerencia / Acción recomendada</label>
              <textarea name="sugerencia" class="form-control" rows="3" placeholder="Ej: Programar cambio de rodamientos, revisar alineación, etc. (opcional)"></textarea>
            </div>

            <!-- FOTO -->
            <div class="col-md-12 mb-3">
              <div class="photo-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="mb-0">
                    <i class="fas fa-camera mr-1"></i> Evidencia fotográfica (opcional)
                  </label>
                  <small style="color:var(--text-secondary);">Se optimiza automáticamente</small>
                </div>

                <div class="row">
                  <div class="col-md-5 mb-2 mb-md-0">
                    <div class="photo-preview" id="previewWrap_anomalia">
                      <div class="photo-empty" id="previewEmpty_anomalia">
                        Sin foto. Sube una imagen si es posible.
                      </div>
                      <img id="previewImg_anomalia" src="" alt="Previsualización" style="display:none;max-width:100%;border-radius:3px;">
                    </div>
                  </div>
                  <div class="col-md-7">
                    <input id="foto_anomalia" type="file" name="foto" class="form-control" accept="image/*">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button id="btnGuardarAnomalia" type="submit" class="btn btn-danger-solid btn-fw">
            <i class="fas fa-save mr-1"></i> Reportar Anomalía
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
  function bytesToMB(bytes){ return (bytes / (1024*1024)).toFixed(2); }

  async function compressToJpeg(file, maxDim = 1920, quality = 0.82){
    let bitmap;
    try{
      bitmap = await createImageBitmap(file);
    }catch(e){
      return file;
    }
    const w = bitmap.width, h = bitmap.height;
    const ratio = Math.min(maxDim / w, maxDim / h, 1);
    const canvas = document.createElement('canvas');
    canvas.width = Math.round(w * ratio);
    canvas.height = Math.round(h * ratio);
    const ctx = canvas.getContext('2d', { alpha: false });
    ctx.drawImage(bitmap, 0, 0, canvas.width, canvas.height);
    const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', quality));
    if(!blob) return file;
    const baseName = (file.name || 'foto').replace(/\.[^/.]+$/, '');
    return new File([blob], `${baseName}.jpg`, { type: 'image/jpeg', lastModified: Date.now() });
  }

  function replaceInputFile(input, file){
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
  }

  async function prepararFotoParaEnvio(file, maxDim = 1920, quality = 0.82){
    const shouldCompress = (file.size > 1.5 * 1024 * 1024) || (file.type === 'image/png');
    if (shouldCompress) return await compressToJpeg(file, maxDim, quality);
    try {
      const buf = await file.arrayBuffer();
      return new File([buf], file.name || 'foto', { type: file.type, lastModified: Date.now() });
    } catch (e) {
      return file;
    }
  }

  let fotoAnomaliaProcessing = null;

  document.addEventListener('DOMContentLoaded', () => {
    const inputFoto = document.getElementById('foto_anomalia');
    const form = document.getElementById('formAgregarAnomalia');
    const btnGuardar = document.getElementById('btnGuardarAnomalia');
    const msgBox = document.getElementById('msgFormAnomalia');

    inputFoto.addEventListener('change', () => {
      msgBox.classList.add('d-none');
      const file = inputFoto.files && inputFoto.files[0];
      if(!file) return;

      if(!file.type.startsWith('image/')){
        inputFoto.value = '';
        msgBox.textContent = 'El archivo seleccionado no es una imagen válida.';
        msgBox.classList.remove('d-none');
        return;
      }

      const empty = document.getElementById('previewEmpty_anomalia');
      const img = document.getElementById('previewImg_anomalia');
      empty.style.display = 'none';
      img.style.display = 'block';
      img.src = URL.createObjectURL(file);

      fotoAnomaliaProcessing = (async () => {
        const optimized = await prepararFotoParaEnvio(file);
        if(optimized && optimized !== file){
          replaceInputFile(inputFoto, optimized);
          img.src = URL.createObjectURL(optimized);
        }
      })();
    });

    form.addEventListener('submit', async (e) => {
      if(btnGuardar.dataset.loading === '1'){
        e.preventDefault();
        return;
      }
      if(fotoAnomaliaProcessing){
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
        try{ await fotoAnomaliaProcessing; }catch(err){}
      }
      btnGuardar.dataset.loading = '1';
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
    });
  });

  $(function () {
    $('#tablaAnomalias').DataTable({
      responsive: true,
      autoWidth: false,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay anomalías registradas."
      },
      columnDefs: [{ orderable: false, targets: -1 }],
      pageLength: 10
    });
  });
</script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

</body>
</html>
