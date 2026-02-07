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


        </ul>
      </nav>
    </div>
  </aside>




  <!-- Content -->
  <div class="content-wrapper p-4">

    <div class="content-header py-3 border-bottom" style="background-color:#f9fafb;">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
          <h1 class="m-0 font-weight-bold" style="color:#333; font-size:1.35rem;">
            CONTROL Y SEGUIMIENTO DE CARTAS — FISCALIZACIÓN (FIS)
          </h1>
          <div class="text-muted" style="font-size:.9rem;">Gestión y seguimiento interno</div>
        </div>
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregarFis">
          <i class="fas fa-plus mr-1"></i> Nueva Carta FIS
        </button>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success mt-3 shadow-sm">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
      </div>
    @endif

    <section class="content mt-4">
      <div class="container-fluid">
        <div class="card shadow-sm border-0">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
              <h5 class="m-0">Listado de Cartas FIS</h5>

              @if($cartas instanceof \Illuminate\Pagination\LengthAwarePaginator)
              <div class="text-muted">
                Mostrando <strong>{{ $cartas->firstItem() }}</strong> a <strong>{{ $cartas->lastItem() }}</strong> de <strong>{{ $cartas->total() }}</strong> registros
              </div>
              @endif
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Servicio o Compra</th>
                    <th>Proveedor Elegido</th>
                    <th>Monto (S/)</th>
                    <th>Monto ($)</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($cartas as $index => $carta)
                    <tr>
                      <td>
                        @if($cartas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                          {{ $cartas->firstItem() + $index }}
                        @else
                          {{ $index + 1 }}
                        @endif
                      </td>

                      <td class="font-weight-bold text-primary">{{ $carta->codigo }}</td>
                      <td>{{ $carta->fecha ? \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') : '—' }}</td>
                      <td>{{ $carta->servicio_compra }}</td>
                      <td>{{ $carta->proveedor_elegido }}</td>
                      <td>{{ $carta->monto_soles }}</td>
                      <td>{{ $carta->monto_dolares }}</td>

                      <!-- Estado (editable rápido) -->
                      <td class="text-center">
                        <form action="{{ route('cartas_fis.update', $carta->id) }}" method="POST" class="m-0">
                          @csrf
                          @method('PUT')

                          @php
                            $estado = $carta->estado ?? 'Pendiente';
                            $dotClass = $estado === 'Ejecutado' ? 'dot-ejecutado' : ($estado === 'Rechazado' ? 'dot-rechazado' : 'dot-pendiente');
                            $selClass = $estado === 'Ejecutado' ? 'sel-ejecutado' : ($estado === 'Rechazado' ? 'sel-rechazado' : 'sel-pendiente');
                          @endphp

                          <div class="estado-wrap">
                            <span class="estado-dot {{ $dotClass }}"></span>

                            <select name="estado" class="estado-select {{ $selClass }}" onchange="this.form.submit()">
                              <option value="Pendiente" {{ $estado=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                              <option value="Ejecutado" {{ $estado=='Ejecutado' ? 'selected' : '' }}>Ejecutado</option>
                              <option value="Rechazado" {{ $estado=='Rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                          </div>

                          <!-- Mantener campos existentes sin tocar (evita overwrites si tu update usa $request->all()) -->
                          <input type="hidden" name="codigo" value="{{ $carta->codigo }}">
                          <input type="hidden" name="fecha" value="{{ $carta->fecha }}">
                          <input type="hidden" name="mes" value="{{ $carta->mes }}">
                          <input type="hidden" name="area" value="{{ $carta->area }}">
                          <input type="hidden" name="servicio_compra" value="{{ $carta->servicio_compra }}">
                          <input type="hidden" name="descripcion" value="{{ $carta->descripcion }}">
                          <input type="hidden" name="proveedor_elegido" value="{{ $carta->proveedor_elegido }}">
                          <input type="hidden" name="cotizaciones_consideradas" value="{{ $carta->cotizaciones_consideradas }}">
                          <input type="hidden" name="equipo" value="{{ $carta->equipo }}">
                          <input type="hidden" name="especificacion" value="{{ $carta->especificacion }}">
                          <input type="hidden" name="monto_soles" value="{{ $carta->monto_soles }}">
                          <input type="hidden" name="monto_dolares" value="{{ $carta->monto_dolares }}">
                          <input type="hidden" name="nro_orden" value="{{ $carta->nro_orden }}">
                          <input type="hidden" name="autorizado_por" value="{{ $carta->autorizado_por }}">
                          <input type="hidden" name="factura_nro" value="{{ $carta->factura_nro }}">
                          <input type="hidden" name="fecha_recepcion" value="{{ $carta->fecha_recepcion }}">
                          <input type="hidden" name="fecha_vencimiento" value="{{ $carta->fecha_vencimiento }}">
                          <input type="hidden" name="fecha_pago" value="{{ $carta->fecha_pago }}">
                        </form>
                      </td>

                      <td class="text-center">
                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditarFis{{ $carta->id }}">
                          <i class="fas fa-edit"></i>
                        </button>
                      </td>
                    </tr>

                  @empty
                    <tr>
                      <td colspan="9" class="text-center text-muted">No hay cartas FIS registradas.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
              {{ $cartas->links() }}
            </div>

          </div>
        </div>
        <div class="d-flex gap-2">
    <a href="{{ route('cartas_fis.excel') }}" class="btn btn-success d-flex align-items-center">
        <i class="fas fa-file-excel me-2"></i> Excel FIS
    </a>

    <a href="{{ route('cartas_fis.backup') }}" class="btn btn-dark d-flex align-items-center">
        <i class="fas fa-database me-2"></i> Generar Backup
    </a>
</div>
      </div>
      
    </section>

  </div>



  
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © {{ date('Y') }}</strong> Todos los derechos reservados.
  </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<!-- ===================== MODAL AGREGAR FIS ===================== -->
<div class="modal fade" id="modalAgregarFis" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFisLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 14px;">
      <div class="modal-header text-white" style="background:linear-gradient(135deg,#003366,#002B5C);">
        <h5 class="modal-title" id="modalAgregarFisLabel">
          <i class="fas fa-plus-circle mr-2"></i> Nueva Carta FIS
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('cartas_fis.store') }}" method="POST">
        @csrf
        <div class="modal-body">

          <div class="row">
            <div class="col-md-4">
              <label><strong>Código</strong></label>
              <input type="text" class="form-control" name="codigo" required>
            </div>
            <div class="col-md-4">
              <label><strong>Fecha</strong></label>
              <input type="date" class="form-control" name="fecha" required>
            </div>
            <div class="col-md-4">
              <label><strong>Mes</strong></label>
              <input type="text" class="form-control" name="mes" required>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label><strong>Área</strong></label>
              <input type="text" class="form-control" name="area">
            </div>
            <div class="col-md-6">
              <label><strong>Autorizado por</strong></label>
              <input type="text" class="form-control" name="autorizado_por">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label><strong>Servicio / Compra</strong></label>
              <input type="text" class="form-control" name="servicio_compra" required>
            </div>
            <div class="col-md-6">
              <label><strong>Descripción</strong></label>
              <textarea class="form-control" name="descripcion" rows="2" required></textarea>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label><strong>Proveedor elegido</strong></label>
              <input type="text" class="form-control" name="proveedor_elegido" required>
            </div>
            <div class="col-md-6">
              <label><strong>Cotizaciones consideradas</strong></label>
              <input type="text" class="form-control" name="cotizaciones_consideradas">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label><strong>Equipo</strong></label>
              <input type="text" class="form-control" name="equipo">
            </div>
            <div class="col-md-4">
              <label><strong>Especificación</strong></label>
              <input type="text" class="form-control" name="especificacion">
            </div>
            <div class="col-md-4">
              <label><strong>N° Orden</strong></label>
              <input type="text" class="form-control" name="nro_orden">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-3">
              <label><strong>Monto (S/)</strong></label>
              <input type="number" step="0.01" class="form-control" name="monto_soles">
            </div>
            <div class="col-md-3">
              <label><strong>Monto ($)</strong></label>
              <input type="number" step="0.01" class="form-control" name="monto_dolares">
            </div>
            <div class="col-md-6">
              <label><strong>Estado</strong></label>
              <select class="form-control" name="estado">
                <option value="Pendiente" selected>Pendiente</option>
                <option value="Ejecutado">Ejecutado</option>
                <option value="Rechazado">Rechazado</option>
              </select>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label><strong>Factura N°</strong></label>
              <input type="text" class="form-control" name="factura_nro">
            </div>
            <div class="col-md-4">
              <label><strong>Fecha recepción</strong></label>
              <input type="date" class="form-control" name="fecha_recepcion">
            </div>
            <div class="col-md-4">
              <label><strong>Fecha vencimiento</strong></label>
              <input type="date" class="form-control" name="fecha_vencimiento">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-4">
              <label><strong>Fecha de pago</strong></label>
              <input type="date" class="form-control" name="fecha_pago">
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Carta</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===================== MODALES EDITAR (UNO POR REGISTRO) ===================== -->
@foreach($cartas as $carta)
<div class="modal fade" id="modalEditarFis{{ $carta->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarFisLabel{{ $carta->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title" id="modalEditarFisLabel{{ $carta->id }}">
          Editar Carta FIS — {{ $carta->codigo }}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="{{ route('cartas_fis.update', $carta->id) }}" method="POST">
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
              <input type="date" name="fecha"
                     value="{{ old('fecha', $carta->fecha ? \Carbon\Carbon::parse($carta->fecha)->format('Y-m-d') : '') }}"
                     class="form-control" required>
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
              <input type="text" name="cotizaciones_consideradas" value="{{ old('cotizaciones_consideradas', $carta->cotizaciones_consideradas) }}" class="form-control">
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
              <input type="date" name="fecha_recepcion"
                     value="{{ old('fecha_recepcion', $carta->fecha_recepcion ? \Carbon\Carbon::parse($carta->fecha_recepcion)->format('Y-m-d') : '') }}"
                     class="form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Fecha Vencimiento</label>
              <input type="date" name="fecha_vencimiento"
                     value="{{ old('fecha_vencimiento', $carta->fecha_vencimiento ? \Carbon\Carbon::parse($carta->fecha_vencimiento)->format('Y-m-d') : '') }}"
                     class="form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Fecha de Pago</label>
              <input type="date" name="fecha_pago"
                     value="{{ old('fecha_pago', $carta->fecha_pago ? \Carbon\Carbon::parse($carta->fecha_pago)->format('Y-m-d') : '') }}"
                     class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Estado</label>
              <select name="estado" class="form-control">
                <option value="Pendiente" {{ ($carta->estado ?? 'Pendiente')=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Ejecutado" {{ ($carta->estado ?? '')=='Ejecutado' ? 'selected' : '' }}>Ejecutado</option>
                <option value="Rechazado" {{ ($carta->estado ?? '')=='Rechazado' ? 'selected' : '' }}>Rechazado</option>
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>

      </form>
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

<script>
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });
</script>

</body>
</html>
