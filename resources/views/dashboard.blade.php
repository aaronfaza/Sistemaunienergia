<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportes de Mantenimiento Mecannico</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <!-- DataTables (Bootstrap 4) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

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
    .wrapper{
      height: 100vh;
      overflow: hidden;
    }
    /* Navbar */
    .navbar-uni { background-color: var(--brand-primary); box-shadow: 0 2px 4px rgba(0,0,0,.2); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand { color: var(--text-on-brand); }
    .navbar-uni .nav-link:hover { opacity: .9; }
    .main-header{
      position: sticky; top: 0; z-index: 1035; height: var(--header-h);
    }

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

    /* Cards */
    .card-clean { border: 1px solid rgba(0,0,0,.06); box-shadow: 0 2px 10px rgba(0,0,0,.04); }

    /* Botones con paleta */
    .btn-brand { background-color: var(--brand-accent); color: #fff; border-color: var(--brand-accent); }
    .btn-brand:hover { background-color: var(--brand-accent-dark); border-color: var(--brand-accent-dark); color:#fff; }
    .btn-outline-brand { border-color: var(--brand-accent); color: var(--brand-accent); }
    .btn-outline-brand:hover { background-color: var(--brand-accent); color:#fff; }
    .btn-primary { background-color: var(--brand-primary); border-color: var(--brand-primary); }
    .btn-primary:hover { background-color: var(--brand-primary-dark); border-color: var(--brand-primary-dark); }
    .btn-info { background-color: var(--brand-info); border-color: var(--brand-info); }
    .btn-danger { background-color: var(--brand-danger); border-color: var(--brand-danger); }
    .btn-fw { font-weight: 600; }

    /* Badges noti */
    .badge-narrow { font-size: .65rem; padding: .2rem .35rem; }

    /* Tabla */
    table.dataTable thead th { white-space: nowrap; }
    .table thead th { font-weight: 600; }

    /* Responsive helpers */
    @media (max-width: 576px) {
      .content-header .btn { width: 100%; }
      .filters-row .form-control { width: 100% !important; }
    }

    /* ======================================================
   MANTENIMIENTO – UX/UI ENTERPRISE UNIENERGIA
   ====================================================== */

/* =========================
   CARDS GENERALES
   ========================= */
.card-clean {
  border-radius: 18px;
  border: 1px solid rgba(0,0,0,.05);
  box-shadow: 0 14px 34px rgba(15,23,42,.06);
}

.card-clean .card-header {
  background: linear-gradient(180deg, #ffffff, #f9fafb);
  font-weight: 600;
  letter-spacing: .2px;
}

/* =========================
   BOTONES – SISTEMA UNIFICADO
   ========================= */
.btn {
  border-radius: 999px !important;
  font-weight: 600;
  letter-spacing: .2px;
  transition: all .2s ease;
}

/* Crear / Guardar */
.btn-brand {
  background: linear-gradient(135deg, #2563eb, #1e40af);
  border: none;
  color: #fff !important;
  box-shadow: 0 8px 20px rgba(37,99,235,.35);
}
.btn-brand:hover {
  transform: translateY(-1px);
  box-shadow: 0 14px 32px rgba(37,99,235,.45);
}

/* Buscar */
.btn-primary {
  background: linear-gradient(135deg, #003366, #002B5C);
  border: none;
  box-shadow: 0 6px 18px rgba(0,51,102,.35);
}
.btn-primary:hover {
  box-shadow: 0 12px 26px rgba(0,51,102,.45);
}

/* Ver */
.btn-info {
  background: linear-gradient(135deg, #0ea5e9, #0369a1);
  border: none;
  box-shadow: 0 6px 16px rgba(14,165,233,.35);
}
.btn-info:hover {
  box-shadow: 0 12px 26px rgba(14,165,233,.45);
}

/* Editar */
.btn-outline-brand {
  border-radius: 999px;
  border: 1px solid rgba(16,185,129,.45);
  color: #10b981;
}
.btn-outline-brand:hover {
  background: rgba(16,185,129,.12);
}

/* Eliminar */
.btn-danger {
  background: rgba(239,68,68,.12);
  border: none;
  color: #ef4444;
}
.btn-danger:hover {
  background: rgba(239,68,68,.22);
}

/* =========================
   TABLA DE REPORTES (NO BOOTSTRAP LOOK)
   ========================= */
#tablaReportes {
  border-collapse: separate !important;
  border-spacing: 0 8px;
}

#tablaReportes thead th {
  background: #f8fafc !important;
  border: none !important;
  font-size: .78rem;
  text-transform: uppercase;
  letter-spacing: .05em;
  color: #475569;
  padding: .75rem;
}

#tablaReportes tbody tr {
  background: #ffffff;
  box-shadow: 0 6px 18px rgba(15,23,42,.06);
  transition: transform .18s ease, box-shadow .18s ease;
}

#tablaReportes tbody tr:hover {
  transform: translateY(-1px);
  box-shadow: 0 14px 32px rgba(15,23,42,.12);
}

#tablaReportes tbody td {
  border: none !important;
  vertical-align: middle;
  padding: .65rem .75rem;
  font-size: .9rem;
  color: #1e293b;
}

/* Primera columna (Nombre) */
#tablaReportes tbody td:first-child {
  font-weight: 600;
  color: #2563eb;
}

/* =========================
   DATATABLES CONTROLES
   ========================= */
.dataTables_wrapper .dataTables_filter input {
  border-radius: 999px;
  padding: .4rem .9rem;
  font-size: .85rem;
  border: 1px solid #cbd5e1;
}

.dataTables_wrapper .dataTables_length select {
  border-radius: 999px;
  font-size: .85rem;
  padding: .3rem .6rem;
}

/* Paginación */
.page-item .page-link {
  border-radius: 999px !important;
  border: none;
  margin: 0 2px;
  color: #334155;
}

.page-item.active .page-link {
  background: linear-gradient(135deg, #2563eb, #1e40af);
  color: #fff;
  box-shadow: 0 6px 16px rgba(37,99,235,.4);
}

/* =========================
   FILTROS (BUSQUEDA)
   ========================= */
.filters-row {
  background: #ffffff;
  border-radius: 16px;
  padding: .85rem 1rem;
  box-shadow: 0 8px 22px rgba(15,23,42,.05);
}

/* =========================
   MODALES – LOOK ENTERPRISE
   ========================= */
.modal-content {
  border-radius: 20px !important;
  box-shadow: 0 24px 48px rgba(15,23,42,.25);
}

.modal-header,
.modal-footer {
  border-color: rgba(0,0,0,.05);
}

/* =========================
   FORMULARIOS
   ========================= */
.form-control,
.custom-select {
  border-radius: 12px;
  font-size: .9rem;
  transition: border-color .15s ease, box-shadow .15s ease;
}

.form-control:focus,
.custom-select:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37,99,235,.18);
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
            @if($notificaciones->count() > 0)
              <span id="notiBadge" class="badge badge-danger position-absolute" style="top:-4px;right:-8px;font-size:.65rem;">
                {{ $notificaciones->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificacionesDropdown" style="min-width:300px;max-height:400px;overflow-y:auto;">
            <h6 class="dropdown-header font-weight-bold text-dark">🔔 Últimos registros</h6>
            <div class="dropdown-divider"></div>
            @forelse($notificaciones as $notificacion)
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
              <p class="text-muted small mb-0">Usuario activo</p>
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
          </ul>

        </li>


        </ul>
      </nav>
    </div>
  </aside>


  <!-- Contenido principal (SCROLL AQUÍ) -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom">
      <div class="container-fluid">
        <h1 class="m-0 heading-font" style="color:#333;">Registro de Mantenimiento</h1>
        <h5 class="text-muted" style="margin-top:4px;">Servicios Mecanicos</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-left:4px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
    </div>

    <!-- Card título + botón -->
    <div class="container-fluid">
      <div class="card card-clean mb-3">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h3 class="card-title m-0 heading-font" style="color:#333;">Registrar nuevo reporte</h3>
            <button class="btn btn-brand btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-1"></i> Agregar Registro
            </button>
          </div>
        </div>
      </div>

      <!-- Filtros -->
      <div class="filters-row mb-3">
        <form action="{{ route('reportes.index') }}" method="GET" class="form-inline">
          <div class="form-group mr-2 mb-2">
            <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
          </div>
          <div class="form-group mr-2 mb-2">
            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
          </div>
          <button type="submit" class="btn btn-primary btn-fw mb-2">
            <i class="fas fa-search mr-1"></i> Buscar
          </button>
        </form>
      </div>

      <!-- Tabla de reportes -->
      <div class="card card-clean">
        <div class="card-header bg-white border-bottom d-flex justify-content-center align-items-center">
          <h3 class="card-title mb-0 heading-font" style="color:#333;">📋 REPORTES DE MANTENIMIENTO MECÁNICO</h3>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table id="tablaReportes" class="table table-hover table-bordered align-middle text-center" style="width:100%;">
              <thead class="thead-light">
                <tr class="text-muted">
                  <th>Nombre</th>
                  <th>Título</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Término</th>
                  <th>Ubicación</th>
                  <th>Tipo de equipo</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($reportes as $reporte)
                  <tr>
                    <td>{{ $reporte->nombre }}</td>
                    <td>{{ $reporte->titulo }}</td>
                    <td>{{ $reporte->fecha_inicio }}</td>
                    <td>{{ $reporte->fecha_termino }}</td>
                    <td>{{ $reporte->ubicacion }}</td>
                    <td>{{ $reporte->tipo_equipo }}</td>
                    <td>
                      <a href="{{ route('reportes.show', $reporte->id) }}"
                         class="btn btn-sm btn-info btn-fw mr-1"
                         title="Ver Reporte" target="_blank">
                        <i class="fas fa-eye mr-1"></i> Ver
                      </a>

                      <button type="button"
                              class="btn btn-sm btn-outline-brand btn-fw mr-1"
                              data-toggle="modal" data-target="#editarModal{{ $reporte->id }}">
                        <i class="fas fa-edit mr-1"></i> Editar
                      </button>

                      <form action="{{ route('reportes.destroy', $reporte->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('¿Estás seguro de eliminar este reporte?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger btn-fw" title="Eliminar">
                          <i class="fas fa-trash mr-1"></i> Eliminar
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  {{-- Sin fila con colspan para no romper DataTables --}}
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="px-3 py-2 text-right">
            <span class="text-muted">Total de reportes: <strong>{{ $reportes->count() }}</strong></span>
          </div>
        </div>
      </div>
    </div> <!-- /.container-fluid -->
  </div> <!-- /.content-wrapper -->

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © 2025</strong> Todos los derechos reservados.
  </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<!-- ========== Modales ========== -->
@foreach($reportes as $reporte)
<div class="modal fade" id="editarModal{{ $reporte->id }}" tabindex="-1" role="dialog" aria-labelledby="editarLabel{{ $reporte->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form method="POST" action="{{ route('reportes.update', $reporte->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="editarLabel{{ $reporte->id }}" style="color:#333;">
            ✏️ Editar Reporte de Mantenimiento
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control shadow-sm" value="{{ $reporte->nombre }}" required>
            </div>
            <div class="col-md-8 mb-3">
              <label>Título del reporte</label>
              <input type="text" name="titulo" class="form-control shadow-sm" value="{{ $reporte->titulo }}" required>
            </div>

            <div class="col-md-4 mb-3">
              <label>Fecha de inicio</label>
              <input type="date" name="fecha_inicio" class="form-control shadow-sm" value="{{ $reporte->fecha_inicio }}" required>
            </div>
            <div class="col-md-4 mb-3">
              <label>Fecha de término</label>
              <input type="date" name="fecha_termino" class="form-control shadow-sm" value="{{ $reporte->fecha_termino }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="tipo_equipo_{{ $reporte->id }}">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo_{{ $reporte->id }}" class="form-control shadow-sm" required>
                <option value="">Seleccione una opción</option>
                <option value="Motor" {{ $reporte->tipo_equipo == 'Motor' ? 'selected' : '' }}>Motor</option>
                <option value="Unidad de Bombeo Mecánico" {{ $reporte->tipo_equipo == 'Unidad de Bombeo Mecánico' ? 'selected' : '' }}>Unidad de Bombeo Mecánico</option>
                <option value="Bomba de Transferencia" {{ $reporte->tipo_equipo == 'Bomba de Transferencia' ? 'selected' : '' }}>Bomba de Transferencia</option>
                <option value="Caja Reductora" {{ $reporte->tipo_equipo == 'Caja Reductora' ? 'selected' : '' }}>Caja Reductora</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Ubicación</label>
              <input type="text" name="ubicacion" class="form-control shadow-sm" value="{{ $reporte->ubicacion }}" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Rotulado</label>
              <input type="text" name="rotulado" class="form-control shadow-sm" value="{{ $reporte->rotulado }}">
            </div>

            <div class="col-md-6 mb-3">
              <label>Herramientas <small>(separadas por coma)</small></label>
              <input type="text" name="herramientas" class="form-control shadow-sm"
                     value="{{ is_array($reporte->herramientas) ? implode(', ', $reporte->herramientas) : $reporte->herramientas }}">
            </div>

            <div class="col-md-6 mb-3">
              <label>Materiales <small>(separados por coma)</small></label>
              <input type="text" name="materiales" class="form-control shadow-sm"
                     value="{{ is_array($reporte->materiales) ? implode(', ', $reporte->materiales) : $reporte->materiales }}">
            </div>

            <div class="col-md-12 mb-3">
              <label>Descripción de la actividad</label>
              <textarea name="descripcion_actividad" class="form-control shadow-sm" rows="3">{{ $reporte->descripcion_actividad }}</textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-brand btn-fw">
            <i class="fas fa-save mr-1"></i> Guardar cambios
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- Modal Agregar Registro -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form method="POST" action="{{ route('reportes.store') }}">
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarLabel" style="color:#333;">🛠️ Nuevo Reporte de Mantenimiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control shadow-sm" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="col-md-8 mb-3">
              <label>Título</label>
              <input type="text" name="titulo" class="form-control shadow-sm" required>
            </div>

            <div class="col-md-4 mb-3">
              <label>Fecha de inicio</label>
              <input type="date" name="fecha_inicio" class="form-control shadow-sm" required>
            </div>
            <div class="col-md-4 mb-3">
              <label>Fecha de término</label>
              <input type="date" name="fecha_termino" class="form-control shadow-sm" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="tipo_equipo_new">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo_new" class="form-control shadow-sm" required>
                <option value="">Seleccione una opción</option>
                <option value="Motor">Motor</option>
                <option value="Unidad de Bombeo Mecánico">Unidad de Bombeo Mecánico</option>
                <option value="Bomba de Transferencia">Bomba de Transferencia</option>
                <option value="Caja Reductora">Caja Reductora</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Ubicación</label>
              <input type="text" name="ubicacion" class="form-control shadow-sm">
            </div>

            <div class="col-md-6 mb-3">
              <label>Rotulado</label>
              <input type="text" name="rotulado" class="form-control shadow-sm">
            </div>

            <div class="col-md-6 mb-3">
              <label>Herramientas <small>(separadas por coma)</small></label>
              <input type="text" name="herramientas" class="form-control shadow-sm">
            </div>

            <div class="col-md-6 mb-3">
              <label>Materiales <small>(separados por coma)</small></label>
              <input type="text" name="materiales" class="form-control shadow-sm">
            </div>

            <div class="col-md-12 mb-3">
              <label>Descripción de la actividad</label>
              <textarea name="descripcion_actividad" class="form-control shadow-sm" rows="3"></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-brand btn-fw">
            <i class="fas fa-save mr-1"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- DataTables (jQuery + Bootstrap 4) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(function () {
    // Ocultar badge de notificaciones al abrir
    $('#notificacionesDropdown').on('click', function () { $('#notiBadge').hide(); });

    // DataTables para reportes
    $('#tablaReportes').DataTable({
      responsive: true,
      autoWidth: false,
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay reportes registrados."
      },
      columnDefs: [{ orderable: false, targets: -1 }],
      pageLength: 10
    });
  });
</script>

</body>
</html>
