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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <!-- FullCalendar (CSS correcto v6) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css">

  <!-- (Opcional) DataTables Bootstrap 4 si lo usaras aquí -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> -->

  <style>
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

    /* Tipografía de títulos */
    .heading-font { font-family: 'Montserrat', sans-serif; }

    .card-clean{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-clean .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }

    /* ===== Cards generales (ficha, secciones de modales) ===== */
    .card{
      border-radius:4px;
      border:1px solid var(--border);
      box-shadow:none;
    }
    .card-header{
      background:var(--surface);
      font-weight:600;
      letter-spacing:.1px;
      border-bottom:1px solid var(--border);
    }

    .btn{ border-radius:3px!important; font-weight:600; font-size:.85rem; box-shadow:none!important; transition:background-color .12s ease; }
    .btn-brand{ background:var(--brand-primary); border:1px solid var(--brand-primary-dark); color:#fff!important; }
    .btn-brand:hover{ background:var(--brand-primary-dark); color:#fff; }
    .btn-primary{ background:var(--brand-primary); border:1px solid var(--brand-primary-dark); }
    .btn-primary:hover{ background:var(--brand-primary-dark); }
    .btn-success{ background:var(--surface); border:1px solid var(--brand-accent); color:var(--brand-accent); }
    .btn-success:hover{ background:#EFFAF4; color:var(--brand-accent); }
    .btn-info{ background:var(--surface); border:1px solid var(--brand-info); color:var(--brand-info); }
    .btn-info:hover{ background:#ECFAFB; color:var(--brand-info); }
    .btn-warning{ background:var(--surface); border:1px solid #F5D08A; color:var(--brand-warning); }
    .btn-warning:hover{ background:#FFFBEB; color:var(--brand-warning); }
    .btn-danger{ background:var(--surface); border:1px solid #F3C6C6; color:var(--brand-danger); }
    .btn-danger:hover{ background:#FEF2F2; color:var(--brand-danger); }
    .btn-outline-secondary{ border-radius:3px!important; }
    .btn-fw{ font-weight:600; }

    /* Buscador (ya no en píldora) */
    .input-group .form-control{ border-radius:3px 0 0 3px; }
    .input-group .btn{ border-radius:0 3px 3px 0!important; }

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
    .table{ border-collapse:collapse!important; border-spacing:0; }
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

<style>
/* ===== ESTADOS DE CARTAS ===== */
.estado-select {
  border-radius: 3px;
  font-weight: 600;
  font-size: .78rem;
  padding: 4px 8px;
  border: 1px solid var(--border-strong);
  outline: none;
  cursor: pointer;
  min-width: 120px;
  text-align: center;
  background: var(--surface);
}

/* Pendiente */
.estado-pendiente {
  background: #FFFBEB;
  color: var(--brand-warning);
  border-color: #F5D08A;
}
.estado-pendiente:hover {
  background: #FFF3D6;
}

/* Ejecutado */
.estado-ejecutado {
  background: #EFFAF4;
  color: var(--brand-accent);
  border-color: #BFE3CD;
}
.estado-ejecutado:hover {
  background: #E3F5EA;
}

/* Rechazado */
.estado-rechazado {
  background: #FEF2F2;
  color: var(--brand-danger);
  border-color: #F3C6C6;
}
.estado-rechazado:hover {
  background: #FCE4E4;
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
          <a class="nav-link position-relative" href="#" id="notificacionesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <a class="nav-link dropdown-toggle d-flex align-items-center px-2 py-1 text-white"
             href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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

  <!-- Encabezado -->
  <div class="content-header py-3 border-bottom" style="background-color: #f9fafb;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1 class="m-0 font-weight-bold heading-font" style="color: #333; font-size: 1.5rem;">
        📋 CONTROL Y SEGUIMIENTO DE CARTAS - ÁREA DE PRODUCCION.
      </h1>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modalAgregar">
        Nueva Carta
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
                  <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modalVer{{ $carta->id }}">
                    <i class="fas fa-eye"></i>
                  </button>

                  <!-- Editar -->
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#modalEditar{{ $carta->id }}">
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
            <div class="modal fade" id="modalEditar{{ $carta->id }}" tabindex="-1" aria-hidden="true" data-bs-dismiss="modal">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel{{ $carta->id }}">Editar Carta — {{ $carta->codigo }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar">
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
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
           style="background:var(--brand-accent); border-radius:4px 4px 0 0;">
        <h5 class="modal-title font-weight-bold" id="modalAgregarLabel">
          <i class="fas fa-file-alt mr-2"></i> Registro de Carta SO-PRO
        </h5>
        <button type="button" class="close text-white" data-bs-dismiss="modal">
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
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
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
                      style="background: var(--brand-primary); border-radius:4px 4px 0 0;">
                    <div>
                      <h5 class="modal-title mb-0 font-weight-bold">
                        📄 Carta SO-PRO — {{ $carta->codigo }}
                      </h5>
                      <small class="opacity-75">
                        Registrada el {{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}
                      </small>
                    </div>
                    <button type="button" class="close text-white" data-bs-dismiss="modal">&times;</button>
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

                  <button type="button" class="btn btn-outline-secondary ml-2" data-bs-dismiss="modal">
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
<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display:none;">
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

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


