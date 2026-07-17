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

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand-primary:#003366;
      --brand-primary-dark:#002B5C;
      --brand-accent:#00A86B;
      --brand-accent-dark:#038b5a;
      --brand-info:#17a2b8;
      --brand-danger:#dc3545;
      --sidebar-bg:#121212;
      --sidebar-main:#1F1F1F;
      --text-on-brand:#ffffff;
      --header-h:56px;
      --footer-h:44px;
    }

    html, body{ height:100%; overflow:hidden; }
    .wrapper{ height:100vh; overflow:hidden; }

    .navbar-uni{ background-color:var(--brand-primary); box-shadow:0 2px 4px rgba(0,0,0,.2); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand{ color:var(--text-on-brand); }
    .navbar-uni .nav-link:hover{ opacity:.9; }
    .main-header{ position:sticky; top:0; z-index:1035; height:var(--header-h); }

    .main-sidebar{ background-color:var(--sidebar-main)!important; }
    .brand-area{ background-color:var(--sidebar-bg); }
    .brand-area .brand-text{ color:var(--text-on-brand); }
    .nav-sidebar .nav-link{ color:#eaeaea!important; border-radius:.35rem; margin:0 .25rem; }
    .nav-sidebar .nav-link.active{
      background:linear-gradient(90deg,var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color:#fff!important;
    }
    .nav-sidebar .nav-link:hover{ background-color:rgba(255,255,255,.08)!important; color:#fff!important; }

    .content-wrapper{
      background-color:#f8f9fa;
      height:calc(100vh - var(--header-h) - var(--footer-h));
      overflow:auto;
      -webkit-overflow-scrolling:touch;
    }
    .main-footer{ position:sticky; bottom:0; z-index:1020; background:#fff; }

    @media (min-width:992px){ :root{ --header-h:64px; } }
    .heading-font{ font-family:'Montserrat', sans-serif; }

    .card-clean{ border-radius:18px; border:1px solid rgba(0,0,0,.05); box-shadow:0 14px 34px rgba(15,23,42,.06); }
    .card-clean .card-header{ background:linear-gradient(180deg,#ffffff,#f9fafb); font-weight:600; letter-spacing:.2px; }

    .btn{ border-radius:999px!important; font-weight:600; letter-spacing:.2px; transition:all .2s ease; }
    .btn-brand{ background:linear-gradient(135deg,#2563eb,#1e40af); border:none; color:#fff!important; box-shadow:0 8px 20px rgba(37,99,235,.35); }
    .btn-brand:hover{ transform:translateY(-1px); box-shadow:0 14px 32px rgba(37,99,235,.45); }
    .btn-primary{ background:linear-gradient(135deg,#003366,#002B5C); border:none; box-shadow:0 6px 18px rgba(0,51,102,.35); }
    .btn-info{ background:linear-gradient(135deg,#0ea5e9,#0369a1); border:none; box-shadow:0 6px 16px rgba(14,165,233,.35); }
    .btn-danger{ background:rgba(239,68,68,.12); border:none; color:#ef4444; }
    .btn-danger:hover{ background:rgba(239,68,68,.22); }
    .btn-fw{ font-weight:600; }

    #tablaAnomalias{ border-collapse:separate!important; border-spacing:0 8px; }
    #tablaAnomalias thead th{
      background:#f8fafc!important; border:none!important; font-size:.78rem;
      text-transform:uppercase; letter-spacing:.05em; color:#475569; padding:.75rem; white-space:nowrap;
    }
    #tablaAnomalias tbody tr{ background:#ffffff; box-shadow:0 6px 18px rgba(15,23,42,.06); transition:transform .18s ease, box-shadow .18s ease; }
    #tablaAnomalias tbody tr:hover{ transform:translateY(-1px); box-shadow:0 14px 32px rgba(15,23,42,.12); }
    #tablaAnomalias tbody td{ border:none!important; vertical-align:middle; padding:.65rem .75rem; font-size:.9rem; color:#1e293b; }

    .filters-row{ background:#ffffff; border-radius:16px; padding:.85rem 1rem; box-shadow:0 8px 22px rgba(15,23,42,.05); }

    .modal-content{ border-radius:20px!important; box-shadow:0 24px 48px rgba(15,23,42,.25); }
    .modal-header, .modal-footer{ border-color:rgba(0,0,0,.05); }

    .form-control, .custom-select{ border-radius:12px; font-size:.9rem; transition:border-color .15s ease, box-shadow .15s ease; }
    .form-control:focus, .custom-select:focus{ border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.18); }

    .gravedad-badge{ font-weight:700; padding:.35rem .7rem; border-radius:999px; font-size:.78rem; }
    .gravedad-Baja{ background:rgba(16,185,129,.15); color:#047857; }
    .gravedad-Media{ background:rgba(245,158,11,.18); color:#b45309; }
    .gravedad-Alta{ background:rgba(239,68,68,.15); color:#b91c1c; }
    .gravedad-Crítica{ background:#dc3545; color:#fff; }

    .estado-select{
      border-radius:999px; font-weight:600; font-size:.8rem; padding:4px 10px;
      border:none; outline:none; cursor:pointer; min-width:130px; text-align:center; transition:all .2s ease;
    }
    .estado-Pendiente{ background:rgba(245,158,11,.18); color:#b45309; }
    .estado-Pendiente:hover{ background:rgba(245,158,11,.30); }
    .estado-EnAtencion{ background:rgba(23,162,184,.18); color:#0e6979; }
    .estado-Resuelta{ background:rgba(16,185,129,.20); color:#047857; }
    .estado-Resuelta:hover{ background:rgba(16,185,129,.32); }

    .photo-card{ border:1px dashed rgba(15,23,42,.18); border-radius:16px; padding:12px; background:linear-gradient(180deg,#fff,#fbfdff); }
    .photo-preview{
      width:100%; height:160px; border-radius:14px; border:1px solid rgba(0,0,0,.06);
      background:#f8fafc; display:flex; align-items:center; justify-content:center; overflow:hidden;
    }
    .photo-preview img{ width:100%; height:100%; object-fit:cover; display:block; }
    .photo-empty{ font-size:.85rem; color:#64748b; text-align:center; padding:10px; }
    .photo-meta{ font-size:.8rem; color:#64748b; margin-top:8px; line-height:1.2; }
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

          @if(!Auth::user()->tieneAccesoLimitadoAMantenimiento())
          <li class="nav-item">
            <a href="{{ route('requerimientos.index') }}" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt" style="color: var(--brand-info);"></i>
              <p class="ml-2 mb-0">Requerimientos</p>
            </a>
          </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-folder-open" style="color: var(--brand-info);"></i>
            <p>
              Control Cartas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview ml-2">
            <li class="nav-item">
              <a href="{{ route('control_cartas.index') }}"
                class="nav-link {{ request()->routeIs('control_cartas.*') ? 'active' : '' }}">
                <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                <p>SO-PRO</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('cartas_fis.index') }}"
                class="nav-link {{ request()->routeIs('cartas_fis.*') ? 'active' : '' }}">
                <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                <p>FIS</p>
              </a>
            </li>
          </ul>
        </li>
         <li class="nav-item">
          <a href="{{ route('logistica_lotes.index') }}"
            class="nav-link {{ request()->routeIs('logistica_lotes.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-boxes" style="color: var(--brand-primary-light);"></i>
              <p class="ms-2 mb-0">Logística Lote</p>
          </a>
      </li>
          @endif

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom">
      <div class="container-fluid">
        <h1 class="m-0 heading-font" style="color:#333;">Anomalías de Pozos</h1>
        <h5 class="text-muted" style="margin-top:4px;">Reporte de fallas en motores, unidades de bombeo y equipos de campo</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-left:4px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
    </div>

    <div class="container-fluid">
      <div class="card card-clean mb-3">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title m-0 heading-font" style="color:#333;">Reportar nueva anomalía</h3>
            <button class="btn btn-danger btn-fw mt-2 mt-sm-0" style="background:linear-gradient(135deg,#ef4444,#b91c1c); color:#fff;" data-toggle="modal" data-target="#modalAgregarAnomalia">
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
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center flex-wrap">
          <h3 class="card-title mb-0 heading-font" style="color:#333;">⚠️ Anomalías Reportadas</h3>
          <span class="text-muted">
            Total: <strong>{{ $totalAnomalias }}</strong> · Pendientes: <strong class="text-danger">{{ $totalPendientes }}</strong>
          </span>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="tablaAnomalias" class="table table-hover align-middle text-center" style="width:100%;">
              <thead class="thead-light">
                <tr class="text-muted">
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
                    <td>{{ $anomalia->created_at->format('d/m/Y H:i') }}</td>
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
                    <td colspan="7" class="text-center text-muted py-4">No hay anomalías registradas.</td>
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

<!-- ========== Modal Reportar Anomalía ========== -->
<div class="modal fade" id="modalAgregarAnomalia" tabindex="-1" role="dialog" aria-labelledby="modalAgregarAnomaliaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form id="formAgregarAnomalia" method="POST" action="{{ route('anomalias.store') }}" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarAnomaliaLabel" style="color:#333;">
            ⚠️ Reportar Anomalía en Pozo
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div id="msgFormAnomalia" class="alert alert-danger d-none"></div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Pozo / Ubicación</label>
              <input type="text" name="pozo" class="form-control shadow-sm" placeholder="Ej: Pozo 14 - Batería Norte" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="tipo_equipo_anomalia">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo_anomalia" class="form-control shadow-sm" required>
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
              <textarea name="descripcion" class="form-control shadow-sm" rows="4" placeholder="Describe qué encontraste: ruido anormal, fuga, vibración, sobrecalentamiento, etc." required></textarea>
            </div>

            <!-- FOTO -->
            <div class="col-md-12 mb-3">
              <div class="photo-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="mb-0 font-weight-bold">
                    <i class="fas fa-camera mr-1"></i> Evidencia fotográfica (opcional)
                  </label>
                  <small class="text-muted">Se optimiza automáticamente</small>
                </div>

                <div class="row">
                  <div class="col-md-5 mb-2 mb-md-0">
                    <div class="photo-preview" id="previewWrap_anomalia">
                      <div class="photo-empty" id="previewEmpty_anomalia">
                        Sin foto. Sube una imagen si es posible.
                      </div>
                      <img id="previewImg_anomalia" src="" alt="Previsualización" style="display:none;max-width:100%;border-radius:10px;">
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
          <button id="btnGuardarAnomalia" type="submit" class="btn btn-brand btn-fw" style="background:linear-gradient(135deg,#ef4444,#b91c1c); color:#fff;">
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
