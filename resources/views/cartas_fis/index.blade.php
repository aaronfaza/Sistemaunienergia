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

    .card-clean, .card{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-clean .card-header, .card .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }

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
    .btn-success{ background:var(--brand-accent); border:1px solid #1F4E37; color:#fff!important; }
    .btn-success:hover{ background:#1F4E37; color:#fff; }
    .btn-dark{ background:var(--surface); border:1px solid var(--border-strong); color:var(--text-primary); }
    .btn-dark:hover{ background:var(--page-bg); color:var(--text-primary); }
    .btn-secondary{ background:var(--surface); border:1px solid var(--border-strong); color:var(--text-primary); }
    .btn-secondary:hover{ background:var(--page-bg); color:var(--text-primary); }
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
    .table{ border-collapse:collapse!important; }
    table thead th{
      background:#F3F4F6!important; border:1px solid var(--border)!important; font-size:.72rem;
      text-transform:uppercase; letter-spacing:.05em; color:var(--text-secondary); padding:.55rem .7rem; white-space:nowrap;
    }
    table tbody tr{ background:var(--surface); }
    table tbody tr:hover{ background:#F8FAFC; }
    table tbody td{ border:1px solid var(--border)!important; vertical-align:middle; padding:.55rem .7rem; font-size:.86rem; color:var(--text-primary); }
    .table tbody td:nth-child(2){ font-weight:600; color:var(--brand-primary); }

    .filters-row{ background:var(--surface); border:1px solid var(--border); border-radius:4px; padding:.75rem 1rem; }

    .modal-content{ border-radius:4px!important; box-shadow:0 2px 12px rgba(0,0,0,.15); }
    .modal-header, .modal-footer{ border-color:var(--border); }

    .form-control, .custom-select, textarea{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus, textarea:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    .empty-state{ padding:2rem 1rem; text-align:center; color:var(--text-secondary); }
    .empty-state i{ font-size:1.8rem; color:var(--border-strong); display:block; margin-bottom:.5rem; }

    .badge{ font-weight:600; padding:.3rem .5rem; border-radius:3px; font-size:.72rem; }

    /* ===== Estado de la carta (select + indicador) ===== */
    .estado-wrap{ display:flex; align-items:center; justify-content:center; gap:.4rem; }
    .estado-dot{ width:8px; height:8px; border-radius:50%; display:inline-block; flex-shrink:0; }
    .dot-pendiente{ background:var(--brand-warning); }
    .dot-ejecutado{ background:var(--brand-accent); }
    .dot-rechazado{ background:var(--brand-danger); }

    .estado-select{
      border-radius:3px;
      font-weight:600;
      font-size:.78rem;
      padding:4px 8px;
      cursor:pointer;
      min-width:120px;
      text-align:center;
    }
    .sel-pendiente{ background:#FFFBEB; border:1px solid #F5D08A; color:var(--brand-warning); }
    .sel-ejecutado{ background:#EFF7F2; border:1px solid #BFE3D0; color:var(--brand-accent); }
    .sel-rechazado{ background:#FEF2F2; border:1px solid #F3C6C6; color:var(--brand-danger); }
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




  <!-- Content -->
  <div class="content-wrapper">

    <div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h1 class="m-0" style="color:var(--text-primary);font-size:1.4rem;font-weight:700;">
            Control y Seguimiento de Cartas — Fiscalización (FIS)
          </h1>
          <h5 class="mb-0" style="margin-top:2px;font-weight:400;font-size:.88rem;color:var(--text-secondary);">Gestión y seguimiento interno</h5>
        </div>
        <button class="btn btn-success btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalAgregarFis">
          <i class="fas fa-plus mr-1"></i> Nueva Carta FIS
        </button>
      </div>
    </div>

    <div class="container-fluid pt-3">

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:4px;border-left:3px solid var(--brand-accent);">
          <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="card card-clean">
          <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
              <h5 class="m-0" style="color:var(--text-primary);font-size:1rem;font-weight:600;">Listado de Cartas FIS</h5>

              @if($cartas instanceof \Illuminate\Pagination\LengthAwarePaginator)
              <div style="color:var(--text-secondary);font-size:.85rem;">
                Mostrando <strong>{{ $cartas->firstItem() }}</strong> a <strong>{{ $cartas->lastItem() }}</strong> de <strong>{{ $cartas->total() }}</strong> registros
              </div>
              @endif
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
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

                      <td class="font-weight-bold">{{ $carta->codigo }}</td>
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
        <div class="d-flex mt-3" style="gap:.5rem;">
          <a href="{{ route('cartas_fis.excel') }}" class="btn btn-success btn-fw d-flex align-items-center">
            <i class="fas fa-file-excel mr-2"></i> Excel FIS
          </a>

          <a href="{{ route('cartas_fis.backup') }}" class="btn btn-dark btn-fw d-flex align-items-center">
            <i class="fas fa-database mr-2"></i> Generar Backup
          </a>
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

<!-- ===================== MODAL AGREGAR FIS ===================== -->
<div class="modal fade" id="modalAgregarFis" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFisLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-white border-bottom">
        <h5 class="modal-title font-weight-semibold" id="modalAgregarFisLabel" style="color:var(--text-primary);">
          <i class="fas fa-plus-circle mr-2" style="color:var(--brand-primary);"></i> Nueva Carta FIS
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
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
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success btn-fw">Guardar Carta</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===================== MODALES EDITAR (UNO POR REGISTRO) ===================== -->
@foreach($cartas as $carta)
<div class="modal fade" id="modalEditarFis{{ $carta->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEditarFisLabel{{ $carta->id }}" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content border-0">
      <div class="modal-header bg-white border-bottom">
        <h5 class="modal-title font-weight-semibold" id="modalEditarFisLabel{{ $carta->id }}" style="color:var(--text-primary);">
          <i class="fas fa-edit mr-1" style="color:var(--brand-warning);"></i> Editar Carta FIS — {{ $carta->codigo }}
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
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success btn-fw">Guardar Cambios</button>
        </div>

      </form>
    </div>
    
  </div>
</div>
@endforeach

<!-- ========== Scripts (orden correcto BS4/AdminLTE3) ========== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });
</script>

</body>
</html>
