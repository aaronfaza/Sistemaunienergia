<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control y Seguimiento Cartas</title>
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

    /* ======================================================
   CONTROL DE CARTAS – UX/UI ENTERPRISE UNIENERGIA
   ====================================================== */

/* =========================
   CARDS GENERALES
   ========================= */
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

/* =========================
   BOTONES – SISTEMA UNIFICADO
   ========================= */
.btn {
  border-radius: 999px !important;
  font-weight: 600;
  letter-spacing: .2px;
  transition: all .2s ease;
}

/* Nueva Carta */
.btn-success {
  background: linear-gradient(135deg, #10b981, #047857);
  border: none;
  box-shadow: 0 8px 20px rgba(16,185,129,.35);
}
.btn-success:hover {
  transform: translateY(-1px);
  box-shadow: 0 14px 32px rgba(16,185,129,.45);
}

/* Buscar */
.btn-primary {
  background: linear-gradient(135deg, #003366, #002B5C);
  border: none;
  box-shadow: 0 6px 18px rgba(0,51,102,.35);
}

/* Ver */
.btn-info {
  background: linear-gradient(135deg, #0ea5e9, #0369a1);
  border: none;
  box-shadow: 0 6px 16px rgba(14,165,233,.35);
}

/* Editar */
.btn-warning {
  background: rgba(245,158,11,.15);
  border: none;
  color: #b45309;
}
.btn-warning:hover {
  background: rgba(245,158,11,.25);
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
   TABLA DE CARTAS (NO BOOTSTRAP LOOK)
   ========================= */
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

/* Código */
.table tbody td:nth-child(2) {
  font-weight: 600;
  color: #2563eb;
}

/* =========================
   BUSCADOR
   ========================= */
.input-group .form-control {
  border-radius: 999px 0 0 999px;
}

.input-group .btn {
  border-radius: 0 999px 999px 0 !important;
}

/* =========================
   MODALES – FICHA CORPORATIVA
   ========================= */
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

/* =========================
   FORMULARIOS
   ========================= */
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

  </style>

<style>
/* ===== ESTADOS DE CARTAS ===== */
.estado-select {
  border-radius: 999px;
  font-weight: 600;
  font-size: 0.8rem;
  padding: 4px 10px;
  border: none;
  outline: none;
  cursor: pointer;
  min-width: 120px;
  text-align: center;
  transition: all .2s ease;
}

/* Pendiente */
.estado-pendiente {
  background: rgba(245, 158, 11, .18);
  color: #b45309;
}
.estado-pendiente:hover {
  background: rgba(245, 158, 11, .30);
}

/* Ejecutado */
.estado-ejecutado {
  background: rgba(16, 185, 129, .20);
  color: #047857;
}
.estado-ejecutado:hover {
  background: rgba(16, 185, 129, .32);
}

/* Rechazado */
.estado-rechazado {
  background: rgba(239, 68, 68, .18);
  color: #b91c1c;
}
.estado-rechazado:hover {
  background: rgba(239, 68, 68, .30);
}
</style>





</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" >
    
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
            <li class="nav-item">
              <a href="{{ route('cartas_fis.index') }}"
                class="nav-link {{ request()->routeIs('cartas_fis.*') ? 'active' : '' }}">
                <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                <p>FIS</p>
              </a>
            </li>
          </ul>
        </li>


        </ul>
      </nav>
    </div>
  </aside>

  




<div class="content-wrapper p-4">

  <!-- Encabezado -->
  <div class="content-header py-3 border-bottom" style="background-color: #f9fafb;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 font-weight-bold heading-font" style="color: #333; font-size: 1.5rem;">
        📋 CONTROL Y SEGUIMIENTO DE CARTAS - ÁREA DE PRODUCCION.
      </h1>
      <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregar" style="border-radius: 8px;">
        <i class="fas fa-plus mr-1"></i> Nueva Carta
      </button>
    </div>
  </div>

 <!-- Contenido principal -->
<section class="content mt-4">
  <div class="container-fluid">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <!-- Buscador -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Listado de Cartas</h5>
        <form method="GET" action="{{ route('control_cartas.index') }}" class="form-inline">
          <div class="input-group">
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar...">
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
        <table class="table table-bordered table-hover">
          <thead class="thead-light">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="text-muted">
                  Mostrando 
                  <strong>{{ $cartas->firstItem() }}</strong>
                  a 
                  <strong>{{ $cartas->lastItem() }}</strong>
                  de 
                  <strong>{{ $cartas->total() }}</strong>
                  registros
              </div>
          </div>

            <tr>
              <th>#</th>
              <th>Código</th>
              <th>Fecha</th>
              <th>Servicio o Compra</th>
              <th>Proveedor Elegido</th>
              <th>Monto (S/)</th>
              <th>Monto ($)</th>
              <th>Estado</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($cartas as $index => $carta)
              <tr>
                <<td>{{ $cartas->firstItem() + $index }}</td>
                <td>{{ $carta->codigo }}</td>
                <td>{{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}</td>
                <td>{{ $carta->servicio_compra }}</td>
                <td>{{ $carta->proveedor_elegido }}</td>
                <td>{{ $carta->monto_soles }}</td>
                <td>{{ $carta->monto_dolares }}</td>
                <td class="text-center">
                <form action="{{ route('control_cartas.update_estado', $carta->id) }}" method="POST">
                  @csrf
                  @method('PATCH')

                  <select name="estado"
                    onchange="this.form.submit()"
                    class="estado-select
                      @if($carta->estado === 'Pendiente') estado-pendiente
                      @elseif($carta->estado === 'Ejecutado') estado-ejecutado
                      @else estado-rechazado
                      @endif">

                    <option value="Pendiente" {{ $carta->estado == 'Pendiente' ? 'selected' : '' }}>
                      🟡 Pendiente
                    </option>

                    <option value="Ejecutado" {{ $carta->estado == 'Ejecutado' ? 'selected' : '' }}>
                      🟢 Ejecutado
                    </option>

                    <option value="Rechazado" {{ $carta->estado == 'Rechazado' ? 'selected' : '' }}>
                      🔴 Rechazado
                    </option>

                  </select>
                </form>
              </td>

                <td class="text-center">
                  <!-- Ver -->
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalVer{{ $carta->id }}">
                    <i class="fas fa-eye"></i>
                  </button>

                  <!-- Editar -->
                  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditar{{ $carta->id }}">
                    <i class="fas fa-edit"></i>
                  </button>

                  <!-- Eliminar -->
                  <form action="{{ route('control_cartas.destroy', $carta->id) }}" method="POST" class="d-inline-block"
                        onsubmit="return confirm('¿Eliminar la carta con código {{ $carta->codigo }}? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
                
              </tr>
  <!-- Modal Editar -->
            <div class="modal fade" id="modalEditar{{ $carta->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel{{ $carta->id }}" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel{{ $carta->id }}">Editar Carta — {{ $carta->codigo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="{{ route('control_cartas.update', $carta->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Código</label>
                          <input type="text" name="codigo" value="{{ old('codigo', $carta->codigo) }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                          <label>Fecha</label>
                          <input type="date" name="fecha" value="{{ old('fecha', $carta->fecha ? \Carbon\Carbon::parse($carta->fecha)->format('Y-m-d') : '') }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-2">
                          <label>Mes</label>
                          <input type="text" name="mes" value="{{ old('mes', $carta->mes) }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                          <label>Área</label>
                          <input type="text" name="area" value="{{ old('area', $carta->area) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Servicio o Compra</label>
                        <input type="text" name="servicio_compra" value="{{ old('servicio_compra', $carta->servicio_compra) }}" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $carta->descripcion) }}</textarea>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Proveedor Elegido</label>
                          <input type="text" name="proveedor_elegido" value="{{ old('proveedor_elegido', $carta->proveedor_elegido) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Cotizaciones Consideradas</label>
                          <input type="text" name="cotizaciones_consideradas" value="{{ old('cotizaciones_consideradas', $carta->cotizaciones_consideradas) }}" class="form-control" placeholder="Separar por comas si aplica">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Equipo</label>
                          <input type="text" name="equipo" value="{{ old('equipo', $carta->equipo) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-8">
                          <label>Especificación</label>
                          <input type="text" name="especificacion" value="{{ old('especificacion', $carta->especificacion) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Monto (S/)</label>
                          <input type="number" step="0.01" name="monto_soles" value="{{ old('monto_soles', $carta->monto_soles) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>Monto ($)</label>
                          <input type="number" step="0.01" name="monto_dolares" value="{{ old('monto_dolares', $carta->monto_dolares) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>N° Orden</label>
                          <input type="text" name="nro_orden" value="{{ old('nro_orden', $carta->nro_orden) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>Autorizado por</label>
                          <input type="text" name="autorizado_por" value="{{ old('autorizado_por', $carta->autorizado_por) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Factura N°</label>
                          <input type="text" name="factura_nro" value="{{ old('factura_nro', $carta->factura_nro) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Fecha Recepción</label>
                          <input type="date" name="fecha_recepcion" value="{{ old('fecha_recepcion', $carta->fecha_recepcion ? \Carbon\Carbon::parse($carta->fecha_recepcion)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Fecha Vencimiento</label>
                          <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $carta->fecha_vencimiento ? \Carbon\Carbon::parse($carta->fecha_vencimiento)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Fecha de Pago</label>
                          <input type="date" name="fecha_pago" value="{{ old('fecha_pago', $carta->fecha_pago ? \Carbon\Carbon::parse($carta->fecha_pago)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


<!-- Modal Agregar Carta -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg" style="border-radius:16px;">

      <!-- HEADER -->
      <div class="modal-header text-white"
           style="background:linear-gradient(135deg,#10b981,#047857); border-radius:16px 16px 0 0;">
        <h5 class="modal-title font-weight-bold" id="modalAgregarLabel">
          <i class="fas fa-file-alt mr-2"></i> Registro de Carta SO-PRO
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form action="{{ route('control_cartas.store') }}" method="POST">
        @csrf

        <div class="modal-body">

          <!-- ================= DATOS GENERALES ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-success">
              <i class="fas fa-info-circle mr-1"></i> Datos generales
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Código</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>
                    <input type="text" class="form-control" name="codigo" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    </div>
                    <input type="date" class="form-control" name="fecha" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Mes</label>
                  <input type="text" class="form-control" name="mes" placeholder="Ej: Marzo" required>
                </div>
              </div>
            </div>
          </div>

          <!-- ================= SERVICIO ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-primary">
              <i class="fas fa-briefcase mr-1"></i> Servicio / Compra
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Servicio o Compra</label>
                  <input type="text" class="form-control" name="servicio_compra" required>
                </div>

                <div class="form-group col-md-6">
                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" rows="2" required></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- ================= PROVEEDOR ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-info">
              <i class="fas fa-industry mr-1"></i> Proveedor
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Proveedor elegido</label>
                  <input type="text" class="form-control" name="proveedor_elegido" required>
                </div>

                <div class="form-group col-md-6">
                  <label>Cotizaciones consideradas</label>
                  <input type="text" class="form-control" name="cotizaciones_consideradas"
                         placeholder="Ej: 3 cotizaciones">
                </div>
              </div>
            </div>
          </div>

          <!-- ================= EQUIPO Y MONTOS ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-warning">
              <i class="fas fa-tools mr-1"></i> Equipo y montos
            </div>
            <div class="card-body">

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Equipo</label>
                  <input type="text" class="form-control" name="equipo">
                </div>

                <div class="form-group col-md-4">
                  <label>Especificación</label>
                  <input type="text" class="form-control" name="especificacion">
                </div>

                <div class="form-group col-md-4">
                  <label>N° Orden</label>
                  <input type="text" class="form-control" name="n_orden">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-3">
                  <label>Monto (S/)</label>
                  <input type="number" step="0.01" class="form-control" name="monto_soles">
                </div>

                <div class="form-group col-md-3">
                  <label>Monto ($)</label>
                  <input type="number" step="0.01" class="form-control" name="monto_dolares">
                </div>

                <div class="form-group col-md-6">
                  <label>Autorizado por</label>
                  <input type="text" class="form-control" name="autorizado_por">
                </div>
              </div>

            </div>
          </div>

          <!-- ================= FECHAS ================= -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-secondary">
              <i class="fas fa-calendar-alt mr-1"></i> Control de fechas
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>N° Factura</label>
                  <input type="text" class="form-control" name="factura_n">
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha recepción</label>
                  <input type="date" class="form-control" name="fecha_recepcion">
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha vencimiento</label>
                  <input type="date" class="form-control" name="fecha_vencimiento">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Fecha de pago</label>
                  <input type="date" class="form-control" name="fecha_pago">
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save mr-1"></i> Guardar Carta
          </button>
        </div>

      </form>
    </div>
  </div>
</div>




      <!-- Modal Ver Detalle (UX Mejorado) -->
            <div class="modal fade" id="modalVer{{ $carta->id }}" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:18px;">

                  <!-- HEADER -->
                  <div class="modal-header text-white"
                      style="background: linear-gradient(135deg, #003366, #002B5C); border-radius:18px 18X|x 0 0;">
                    <div>
                      <h5 class="modal-title mb-0 font-weight-bold">
                        📄 Carta SO-PRO — {{ $carta->codigo }}
                      </h5>
                      <small class="opacity-75">
                        Registrada el {{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}
                      </small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- BODY -->
                  <div class="modal-body">

                    <!-- BLOQUE: DATOS GENERALES -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-3">
                          <i class="fas fa-info-circle mr-1"></i> Datos Generales
                        </h6>

                        <div class="row">
                          <div class="col-md-3"><strong>Mes</strong><br>{{ $carta->mes }}</div>
                          <div class="col-md-3"><strong>Área</strong><br>{{ $carta->area }}</div>
                          <div class="col-md-3"><strong>Autorizado por</strong><br>{{ $carta->autorizado_por }}</div>
                          <div class="col-md-3"><strong>N° Orden</strong><br>{{ $carta->nro_orden ?? '—' }}</div>
                        </div>
                      </div>
                    </div>

                    <!-- BLOQUE: SERVICIO -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-2">
                          <i class="fas fa-briefcase mr-1"></i> Servicio / Compra
                        </h6>
                        <p class="mb-1"><strong>{{ $carta->servicio_compra }}</strong></p>
                        <p class="text-muted mb-0">{{ $carta->descripcion }}</p>
                      </div>
                    </div>

                    <!-- BLOQUE: PROVEEDOR Y MONTOS -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-3">
                          <div class="card-body">
                            <h6 class="text-primary font-weight-bold mb-2">
                              <i class="fas fa-industry mr-1"></i> Proveedor
                            </h6>
                            <p class="mb-1"><strong>Proveedor elegido</strong></p>
                            <p>{{ $carta->proveedor_elegido }}</p>

                            <p class="mb-1"><strong>Cotizaciones</strong></p>
                            <p class="text-muted mb-0">
                              {{ $carta->cotizaciones_consideradas ?? '—' }}
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-3">
                          <div class="card-body">
                            <h6 class="text-primary font-weight-bold mb-2">
                              <i class="fas fa-coins mr-1"></i> Montos
                            </h6>

                            <div class="d-flex justify-content-between">
                              <span>Monto (S/)</span>
                              <span class="font-weight-bold text-success">
                                S/ {{ number_format($carta->monto_soles, 2) }}
                              </span>
                            </div>

                            <div class="d-flex justify-content-between">
                              <span>Monto ($)</span>
                              <span class="font-weight-bold text-info">
                                $ {{ number_format($carta->monto_dolares, 2) }}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- BLOQUE: EQUIPO -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-2">
                          <i class="fas fa-tools mr-1"></i> Equipo / Especificación
                        </h6>
                        <p class="mb-1"><strong>Equipo:</strong> {{ $carta->equipo }}</p>
                        <p class="mb-0"><strong>Especificación:</strong> {{ $carta->especificacion }}</p>
                      </div>
                    </div>

                    <!-- BLOQUE: FECHAS -->
                    <div class="card shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-3">
                          <i class="fas fa-calendar-alt mr-1"></i> Control de Fechas
                        </h6>

                        <div class="row">
                          <div class="col-md-4">
                            <strong>Recepción</strong><br>
                            {{ $carta->fecha_recepcion ?? '—' }}
                          </div>
                          <div class="col-md-4">
                            <strong>Vencimiento</strong><br>
                            {{ $carta->fecha_vencimiento ?? '—' }}
                          </div>
                          <div class="col-md-4">
                            <strong>Pago</strong><br>
                            {{ $carta->fecha_pago ?? '—' }}
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                 <!-- FOOTER -->
              <div class="modal-footer bg-light d-flex justify-content-between align-items-center">

                <div class="text-muted small">
                  <i class="fas fa-file-pdf mr-1"></i>
                  Exportar ficha de la carta
                </div>

                <div>
                  <a href="{{ route('control_cartas.export.pdf.individual', $carta->id) }}"
                    class="btn btn-danger shadow-sm"
                    target="_blank">
                    <i class="fas fa-file-pdf mr-1"></i> Descargar PDF
                  </a>

                  <button type="button" class="btn btn-outline-secondary ml-2" data-dismiss="modal">
                    Cerrar
                  </button>
                </div>

              </div>

            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No hay cartas registradas.</td>
              </tr>
              
            @endforelse
          </tbody>
          <div class="d-flex justify-content-end mt-3">
              {{ $cartas->links('pagination::bootstrap-4') }}
          </div>
        </table>
          
        <div class="d-flex justify-content-end mt-3">
          {{ $cartas->links() }}
        </div>
      </div>
    </div>
  </div>
  
</section>


  
<a href="{{ route('control_cartas.export.excel', ['buscar' => $buscar]) }}"
   class="btn btn-success shadow-sm">
    <i class="fas fa-file-excel mr-1"></i> Backup Excel
</a>



</div>

<!-- Formulario de Cierre de sesión (Logout) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<!-- Footer -->
<footer class="main-footer text-center py-3">
    <div class="container">
        <strong>Unienergia ABC © {{ date('Y') }}</strong> Todos los derechos reservados.
    </div>
</footer>

<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control y Seguimiento Cartas</title>
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

    /* ======================================================
   CONTROL DE CARTAS – UX/UI ENTERPRISE UNIENERGIA
   ====================================================== */

/* =========================
   CARDS GENERALES
   ========================= */
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

/* =========================
   BOTONES – SISTEMA UNIFICADO
   ========================= */
.btn {
  border-radius: 999px !important;
  font-weight: 600;
  letter-spacing: .2px;
  transition: all .2s ease;
}

/* Nueva Carta */
.btn-success {
  background: linear-gradient(135deg, #10b981, #047857);
  border: none;
  box-shadow: 0 8px 20px rgba(16,185,129,.35);
}
.btn-success:hover {
  transform: translateY(-1px);
  box-shadow: 0 14px 32px rgba(16,185,129,.45);
}

/* Buscar */
.btn-primary {
  background: linear-gradient(135deg, #003366, #002B5C);
  border: none;
  box-shadow: 0 6px 18px rgba(0,51,102,.35);
}

/* Ver */
.btn-info {
  background: linear-gradient(135deg, #0ea5e9, #0369a1);
  border: none;
  box-shadow: 0 6px 16px rgba(14,165,233,.35);
}

/* Editar */
.btn-warning {
  background: rgba(245,158,11,.15);
  border: none;
  color: #b45309;
}
.btn-warning:hover {
  background: rgba(245,158,11,.25);
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
   TABLA DE CARTAS (NO BOOTSTRAP LOOK)
   ========================= */
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

/* Código */
.table tbody td:nth-child(2) {
  font-weight: 600;
  color: #2563eb;
}

/* =========================
   BUSCADOR
   ========================= */
.input-group .form-control {
  border-radius: 999px 0 0 999px;
}

.input-group .btn {
  border-radius: 0 999px 999px 0 !important;
}

/* =========================
   MODALES – FICHA CORPORATIVA
   ========================= */
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

/* =========================
   FORMULARIOS
   ========================= */
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

  </style>

<style>
/* ===== ESTADOS DE CARTAS ===== */
.estado-select {
  border-radius: 999px;
  font-weight: 600;
  font-size: 0.8rem;
  padding: 4px 10px;
  border: none;
  outline: none;
  cursor: pointer;
  min-width: 120px;
  text-align: center;
  transition: all .2s ease;
}

/* Pendiente */
.estado-pendiente {
  background: rgba(245, 158, 11, .18);
  color: #b45309;
}
.estado-pendiente:hover {
  background: rgba(245, 158, 11, .30);
}

/* Ejecutado */
.estado-ejecutado {
  background: rgba(16, 185, 129, .20);
  color: #047857;
}
.estado-ejecutado:hover {
  background: rgba(16, 185, 129, .32);
}

/* Rechazado */
.estado-rechazado {
  background: rgba(239, 68, 68, .18);
  color: #b91c1c;
}
.estado-rechazado:hover {
  background: rgba(239, 68, 68, .30);
}
</style>





</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed" >
    
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
            <li class="nav-item">
              <a href="{{ route('cartas_fis.index') }}"
                class="nav-link {{ request()->routeIs('cartas_fis.*') ? 'active' : '' }}">
                <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                <p>FIS</p>
              </a>
            </li>
          </ul>
        </li>


        </ul>
      </nav>
    </div>
  </aside>

  




<div class="content-wrapper p-4">

  <!-- Encabezado -->
  <div class="content-header py-3 border-bottom" style="background-color: #f9fafb;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 font-weight-bold heading-font" style="color: #333; font-size: 1.5rem;">
        📋 CONTROL Y SEGUIMIENTO DE CARTAS - ÁREA DE PRODUCCION.
      </h1>
      <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregar" style="border-radius: 8px;">
        <i class="fas fa-plus mr-1"></i> Nueva Carta
      </button>
    </div>
  </div>

 <!-- Contenido principal -->
<section class="content mt-4">
  <div class="container-fluid">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <!-- Buscador -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="m-0">Listado de Cartas</h5>
        <form method="GET" action="{{ route('control_cartas.index') }}" class="form-inline">
          <div class="input-group">
            <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar...">
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
        <table class="table table-bordered table-hover">
          <thead class="thead-light">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <div class="text-muted">
                  Mostrando 
                  <strong>{{ $cartas->firstItem() }}</strong>
                  a 
                  <strong>{{ $cartas->lastItem() }}</strong>
                  de 
                  <strong>{{ $cartas->total() }}</strong>
                  registros
              </div>
          </div>

            <tr>
              <th>#</th>
              <th>Código</th>
              <th>Fecha</th>
              <th>Servicio o Compra</th>
              <th>Proveedor Elegido</th>
              <th>Monto (S/)</th>
              <th>Monto ($)</th>
              <th>Estado</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($cartas as $index => $carta)
              <tr>
                <<td>{{ $cartas->firstItem() + $index }}</td>
                <td>{{ $carta->codigo }}</td>
                <td>{{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}</td>
                <td>{{ $carta->servicio_compra }}</td>
                <td>{{ $carta->proveedor_elegido }}</td>
                <td>{{ $carta->monto_soles }}</td>
                <td>{{ $carta->monto_dolares }}</td>
                <td class="text-center">
                <form action="{{ route('control_cartas.update_estado', $carta->id) }}" method="POST">
                  @csrf
                  @method('PATCH')

                  <select name="estado"
                    onchange="this.form.submit()"
                    class="estado-select
                      @if($carta->estado === 'Pendiente') estado-pendiente
                      @elseif($carta->estado === 'Ejecutado') estado-ejecutado
                      @else estado-rechazado
                      @endif">

                    <option value="Pendiente" {{ $carta->estado == 'Pendiente' ? 'selected' : '' }}>
                      🟡 Pendiente
                    </option>

                    <option value="Ejecutado" {{ $carta->estado == 'Ejecutado' ? 'selected' : '' }}>
                      🟢 Ejecutado
                    </option>

                    <option value="Rechazado" {{ $carta->estado == 'Rechazado' ? 'selected' : '' }}>
                      🔴 Rechazado
                    </option>

                  </select>
                </form>
              </td>

                <td class="text-center">
                  <!-- Ver -->
                  <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalVer{{ $carta->id }}">
                    <i class="fas fa-eye"></i>
                  </button>

                  <!-- Editar -->
                  <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditar{{ $carta->id }}">
                    <i class="fas fa-edit"></i>
                  </button>

                  <!-- Eliminar -->
                  <form action="{{ route('control_cartas.destroy', $carta->id) }}" method="POST" class="d-inline-block"
                        onsubmit="return confirm('¿Eliminar la carta con código {{ $carta->codigo }}? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
                
              </tr>
  <!-- Modal Editar -->
            <div class="modal fade" id="modalEditar{{ $carta->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarLabel{{ $carta->id }}" aria-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel{{ $carta->id }}">Editar Carta — {{ $carta->codigo }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="{{ route('control_cartas.update', $carta->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Código</label>
                          <input type="text" name="codigo" value="{{ old('codigo', $carta->codigo) }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-3">
                          <label>Fecha</label>
                          <input type="date" name="fecha" value="{{ old('fecha', $carta->fecha ? \Carbon\Carbon::parse($carta->fecha)->format('Y-m-d') : '') }}" class="form-control" required>
                        </div>

                        <div class="form-group col-md-2">
                          <label>Mes</label>
                          <input type="text" name="mes" value="{{ old('mes', $carta->mes) }}" class="form-control">
                        </div>

                        <div class="form-group col-md-4">
                          <label>Área</label>
                          <input type="text" name="area" value="{{ old('area', $carta->area) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label>Servicio o Compra</label>
                        <input type="text" name="servicio_compra" value="{{ old('servicio_compra', $carta->servicio_compra) }}" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $carta->descripcion) }}</textarea>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Proveedor Elegido</label>
                          <input type="text" name="proveedor_elegido" value="{{ old('proveedor_elegido', $carta->proveedor_elegido) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                          <label>Cotizaciones Consideradas</label>
                          <input type="text" name="cotizaciones_consideradas" value="{{ old('cotizaciones_consideradas', $carta->cotizaciones_consideradas) }}" class="form-control" placeholder="Separar por comas si aplica">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Equipo</label>
                          <input type="text" name="equipo" value="{{ old('equipo', $carta->equipo) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-8">
                          <label>Especificación</label>
                          <input type="text" name="especificacion" value="{{ old('especificacion', $carta->especificacion) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label>Monto (S/)</label>
                          <input type="number" step="0.01" name="monto_soles" value="{{ old('monto_soles', $carta->monto_soles) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>Monto ($)</label>
                          <input type="number" step="0.01" name="monto_dolares" value="{{ old('monto_dolares', $carta->monto_dolares) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>N° Orden</label>
                          <input type="text" name="nro_orden" value="{{ old('nro_orden', $carta->nro_orden) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                          <label>Autorizado por</label>
                          <input type="text" name="autorizado_por" value="{{ old('autorizado_por', $carta->autorizado_por) }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label>Factura N°</label>
                          <input type="text" name="factura_nro" value="{{ old('factura_nro', $carta->factura_nro) }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Fecha Recepción</label>
                          <input type="date" name="fecha_recepcion" value="{{ old('fecha_recepcion', $carta->fecha_recepcion ? \Carbon\Carbon::parse($carta->fecha_recepcion)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Fecha Vencimiento</label>
                          <input type="date" name="fecha_vencimiento" value="{{ old('fecha_vencimiento', $carta->fecha_vencimiento ? \Carbon\Carbon::parse($carta->fecha_vencimiento)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label>Fecha de Pago</label>
                          <input type="date" name="fecha_pago" value="{{ old('fecha_pago', $carta->fecha_pago ? \Carbon\Carbon::parse($carta->fecha_pago)->format('Y-m-d') : '') }}" class="form-control">
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


<!-- Modal Agregar Carta -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg" style="border-radius:16px;">

      <!-- HEADER -->
      <div class="modal-header text-white"
           style="background:linear-gradient(135deg,#10b981,#047857); border-radius:16px 16px 0 0;">
        <h5 class="modal-title font-weight-bold" id="modalAgregarLabel">
          <i class="fas fa-file-alt mr-2"></i> Registro de Carta SO-PRO
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form action="{{ route('control_cartas.store') }}" method="POST">
        @csrf

        <div class="modal-body">

          <!-- ================= DATOS GENERALES ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-success">
              <i class="fas fa-info-circle mr-1"></i> Datos generales
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Código</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>
                    <input type="text" class="form-control" name="codigo" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    </div>
                    <input type="date" class="form-control" name="fecha" required>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Mes</label>
                  <input type="text" class="form-control" name="mes" placeholder="Ej: Marzo" required>
                </div>
              </div>
            </div>
          </div>

          <!-- ================= SERVICIO ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-primary">
              <i class="fas fa-briefcase mr-1"></i> Servicio / Compra
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Servicio o Compra</label>
                  <input type="text" class="form-control" name="servicio_compra" required>
                </div>

                <div class="form-group col-md-6">
                  <label>Descripción</label>
                  <textarea class="form-control" name="descripcion" rows="2" required></textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- ================= PROVEEDOR ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-info">
              <i class="fas fa-industry mr-1"></i> Proveedor
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Proveedor elegido</label>
                  <input type="text" class="form-control" name="proveedor_elegido" required>
                </div>

                <div class="form-group col-md-6">
                  <label>Cotizaciones consideradas</label>
                  <input type="text" class="form-control" name="cotizaciones_consideradas"
                         placeholder="Ej: 3 cotizaciones">
                </div>
              </div>
            </div>
          </div>

          <!-- ================= EQUIPO Y MONTOS ================= -->
          <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-warning">
              <i class="fas fa-tools mr-1"></i> Equipo y montos
            </div>
            <div class="card-body">

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Equipo</label>
                  <input type="text" class="form-control" name="equipo">
                </div>

                <div class="form-group col-md-4">
                  <label>Especificación</label>
                  <input type="text" class="form-control" name="especificacion">
                </div>

                <div class="form-group col-md-4">
                  <label>N° Orden</label>
                  <input type="text" class="form-control" name="n_orden">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-3">
                  <label>Monto (S/)</label>
                  <input type="number" step="0.01" class="form-control" name="monto_soles">
                </div>

                <div class="form-group col-md-3">
                  <label>Monto ($)</label>
                  <input type="number" step="0.01" class="form-control" name="monto_dolares">
                </div>

                <div class="form-group col-md-6">
                  <label>Autorizado por</label>
                  <input type="text" class="form-control" name="autorizado_por">
                </div>
              </div>

            </div>
          </div>

          <!-- ================= FECHAS ================= -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-light font-weight-bold text-secondary">
              <i class="fas fa-calendar-alt mr-1"></i> Control de fechas
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>N° Factura</label>
                  <input type="text" class="form-control" name="factura_n">
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha recepción</label>
                  <input type="date" class="form-control" name="fecha_recepcion">
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha vencimiento</label>
                  <input type="date" class="form-control" name="fecha_vencimiento">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>Fecha de pago</label>
                  <input type="date" class="form-control" name="fecha_pago">
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
            Cancelar
          </button>
          <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save mr-1"></i> Guardar Carta
          </button>
        </div>

      </form>
    </div>
  </div>
</div>




      <!-- Modal Ver Detalle (UX Mejorado) -->
            <div class="modal fade" id="modalVer{{ $carta->id }}" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:18px;">

                  <!-- HEADER -->
                  <div class="modal-header text-white"
                      style="background: linear-gradient(135deg, #003366, #002B5C); border-radius:18px 18X|x 0 0;">
                    <div>
                      <h5 class="modal-title mb-0 font-weight-bold">
                        📄 Carta SO-PRO — {{ $carta->codigo }}
                      </h5>
                      <small class="opacity-75">
                        Registrada el {{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}
                      </small>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- BODY -->
                  <div class="modal-body">

                    <!-- BLOQUE: DATOS GENERALES -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-3">
                          <i class="fas fa-info-circle mr-1"></i> Datos Generales
                        </h6>

                        <div class="row">
                          <div class="col-md-3"><strong>Mes</strong><br>{{ $carta->mes }}</div>
                          <div class="col-md-3"><strong>Área</strong><br>{{ $carta->area }}</div>
                          <div class="col-md-3"><strong>Autorizado por</strong><br>{{ $carta->autorizado_por }}</div>
                          <div class="col-md-3"><strong>N° Orden</strong><br>{{ $carta->nro_orden ?? '—' }}</div>
                        </div>
                      </div>
                    </div>

                    <!-- BLOQUE: SERVICIO -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-2">
                          <i class="fas fa-briefcase mr-1"></i> Servicio / Compra
                        </h6>
                        <p class="mb-1"><strong>{{ $carta->servicio_compra }}</strong></p>
                        <p class="text-muted mb-0">{{ $carta->descripcion }}</p>
                      </div>
                    </div>

                    <!-- BLOQUE: PROVEEDOR Y MONTOS -->
                    <div class="row">
                      <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-3">
                          <div class="card-body">
                            <h6 class="text-primary font-weight-bold mb-2">
                              <i class="fas fa-industry mr-1"></i> Proveedor
                            </h6>
                            <p class="mb-1"><strong>Proveedor elegido</strong></p>
                            <p>{{ $carta->proveedor_elegido }}</p>

                            <p class="mb-1"><strong>Cotizaciones</strong></p>
                            <p class="text-muted mb-0">
                              {{ $carta->cotizaciones_consideradas ?? '—' }}
                            </p>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="card shadow-sm border-0 mb-3">
                          <div class="card-body">
                            <h6 class="text-primary font-weight-bold mb-2">
                              <i class="fas fa-coins mr-1"></i> Montos
                            </h6>

                            <div class="d-flex justify-content-between">
                              <span>Monto (S/)</span>
                              <span class="font-weight-bold text-success">
                                S/ {{ number_format($carta->monto_soles, 2) }}
                              </span>
                            </div>

                            <div class="d-flex justify-content-between">
                              <span>Monto ($)</span>
                              <span class="font-weight-bold text-info">
                                $ {{ number_format($carta->monto_dolares, 2) }}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- BLOQUE: EQUIPO -->
                    <div class="card mb-3 shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-2">
                          <i class="fas fa-tools mr-1"></i> Equipo / Especificación
                        </h6>
                        <p class="mb-1"><strong>Equipo:</strong> {{ $carta->equipo }}</p>
                        <p class="mb-0"><strong>Especificación:</strong> {{ $carta->especificacion }}</p>
                      </div>
                    </div>

                    <!-- BLOQUE: FECHAS -->
                    <div class="card shadow-sm border-0">
                      <div class="card-body">
                        <h6 class="text-primary font-weight-bold mb-3">
                          <i class="fas fa-calendar-alt mr-1"></i> Control de Fechas
                        </h6>

                        <div class="row">
                          <div class="col-md-4">
                            <strong>Recepción</strong><br>
                            {{ $carta->fecha_recepcion ?? '—' }}
                          </div>
                          <div class="col-md-4">
                            <strong>Vencimiento</strong><br>
                            {{ $carta->fecha_vencimiento ?? '—' }}
                          </div>
                          <div class="col-md-4">
                            <strong>Pago</strong><br>
                            {{ $carta->fecha_pago ?? '—' }}
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                 <!-- FOOTER -->
              <div class="modal-footer bg-light d-flex justify-content-between align-items-center">

                <div class="text-muted small">
                  <i class="fas fa-file-pdf mr-1"></i>
                  Exportar ficha de la carta
                </div>

                <div>
                  <a href="{{ route('control_cartas.export.pdf.individual', $carta->id) }}"
                    class="btn btn-danger shadow-sm"
                    target="_blank">
                    <i class="fas fa-file-pdf mr-1"></i> Descargar PDF
                  </a>

                  <button type="button" class="btn btn-outline-secondary ml-2" data-dismiss="modal">
                    Cerrar
                  </button>
                </div>

              </div>

            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">No hay cartas registradas.</td>
              </tr>
              
            @endforelse
          </tbody>
          <div class="d-flex justify-content-end mt-3">
              {{ $cartas->links('pagination::bootstrap-4') }}
          </div>
        </table>
          
        <div class="d-flex justify-content-end mt-3">
          {{ $cartas->links() }}
        </div>
      </div>
    </div>
  </div>
  
</section>


  
<a href="{{ route('control_cartas.export.excel', ['buscar' => $buscar]) }}"
   class="btn btn-success shadow-sm">
    <i class="fas fa-file-excel mr-1"></i> Backup Excel
</a>



</div>

<!-- Formulario de Cierre de sesión (Logout) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<!-- Footer -->
<footer class="main-footer text-center py-3">
    <div class="container">
        <strong>Unienergia ABC © {{ date('Y') }}</strong> Todos los derechos reservados.
    </div>
</footer>

<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<!-- Scripts esenciales -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- Script de manejo de notificaciones (esconder el badge cuando se hace clic) -->
<script>
    $(document).ready(function() {
        // Ocultar el badge de notificaciones al hacer clic
        $('#notificacionesDropdown').on('click', function() {
            $('#notiBadge').hide();
        });
    });
</script>

</body>
</html>

</body>
</html>