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
.stat-card.is-info .stat-icon {
    background: rgba(245, 158, 11, 0.1) !important;
    color: #f59e0b !important; /* Color ámbar/naranja para indicar espera */
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded-pill shadow-sm text-white"
             href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
             style="background-color: var(--brand-primary-dark);">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius:12px;min-width:240px;">
            <div class="dropdown-item text-center bg-light py-3">
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

        </ul>
      </nav>
    </div>
  </aside>

<div class="content-wrapper p-4">
<div class="content-header py-3 border-bottom" style="background-color:#f9fafb;">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0 font-weight-bold" style="color:#333; font-size:1.35rem;">
            CONTROL Y SEGUIMIENTO DE ORDENES LOGISTICA LOTE IX
          </h1>
          <div class="text-muted" style="font-size:.9rem;">Gestión y seguimiento interno</div>
        </div>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarLote">
                <i class="fas fa-plus mr-1"></i> Nuevo Registro
        </button>
      </div>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success mt-3 shadow-sm border-0" style="border-radius:12px;">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
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
            <div class="stat-card is-info">
                <div class="stat-icon" style="background: rgba(245, 158, 11, .12); color: #b45309;">
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
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(37, 99, 235, .12); color: #2563eb;">
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
            <div class="row mb-3">
                <div class="col-md-6">
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
            </div>
            <div class="card shadow-sm border-0">
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
                                                    style="border-radius: 20px; font-weight: bold; font-size: 0.85rem; border: none; padding: 2px 10px;
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
    <a href="{{ route('logistica.export') }}" class="btn btn-success shadow-sm">
        <i class="fas fa-file-excel mr-2"></i> Exportar Backup Excel
    </a>
</div>



<div class="modal fade" id="modalAgregarLote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header text-white" style="background:linear-gradient(135deg,#003366,#002B5C); border-radius: 15px 15px 0 0;">
                <h5 class="modal-title"><i class="fas fa-boxes mr-2"></i> Nuevo Registro de Logística</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
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
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($lotes as $lote)
<div class="modal fade" id="modalEditarLote{{ $lote->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-warning" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-2"></i> Editar Registro: {{ $lote->cod_log }}</h5>
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
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary shadow-none" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning px-4 font-weight-bold">Actualizar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>












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
                <div class="row mb-4 bg-light p-3 rounded shadow-sm">
                    <div class="col-md-4">
                        <small class="text-uppercase text-muted d-block">Estado</small>
                        <span class="badge badge-pill p-2 px-3 {{ $lote->estado == 'Finalizado' ? 'bg-success text-white' : ($lote->estado == 'Proceso' ? 'bg-warning' : 'bg-danger text-white') }}">
                            {{ $lote->estado }}
                        </span>
                    </div>
                    <div class="col-md-4 text-center">
                        <small class="text-uppercase text-muted d-block">Progreso</small>
                        <div class="progress mt-1" style="height: 15px; border-radius: 10px;">
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

                <div class="bg-light p-3 rounded" style="border-left: 4px solid #17a2b8;">
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
                    <a href="{{ route('logistica_lotes.pdf', $lote->id) }}" class="btn btn-danger px-4 shadow-sm">
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
