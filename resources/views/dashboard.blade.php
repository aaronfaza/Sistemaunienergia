<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportes de Mantenimiento Mecanico</title>
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

    .signature-card{
      border: 1px solid rgba(0,0,0,.08);
      border-radius: 16px;
      padding: 12px;
      background: #fff;
      box-shadow: 0 10px 24px rgba(15,23,42,.06);
    }
    .signature-head{
      display:flex;
      justify-content:space-between;
      align-items:center;
      margin-bottom:8px;
    }
    .signature-title{
      font-weight:700;
      font-size:.95rem;
      margin:0;
    }
    .signature-hint{
      font-size:.78rem;
      color:#64748b;
      margin:0;
    }
    .signature-wrap{
      border: 1px dashed rgba(0,0,0,.25);
      border-radius: 14px;
      overflow:hidden;
      background: #fbfdff;
    }

    .signature-canvas{
      width: 100%;
      height: 180px;
      display:block;
      touch-action: none; /* evita scroll y mejora táctil */
      cursor: crosshair;
    }
    .signature-actions{
      display:flex;
      gap:8px;
      margin-top:10px;
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

    .card-clean{
      border-radius:18px;
      border:1px solid rgba(0,0,0,.05);
      box-shadow:0 14px 34px rgba(15,23,42,.06);
    }
    .card-clean .card-header{
      background:linear-gradient(180deg,#ffffff,#f9fafb);
      font-weight:600;
      letter-spacing:.2px;
    }

    .btn{
      border-radius:999px!important;
      font-weight:600;
      letter-spacing:.2px;
      transition:all .2s ease;
    }
    .btn-brand{
      background:linear-gradient(135deg,#2563eb,#1e40af);
      border:none;
      color:#fff!important;
      box-shadow:0 8px 20px rgba(37,99,235,.35);
    }
    .btn-brand:hover{ transform:translateY(-1px); box-shadow:0 14px 32px rgba(37,99,235,.45); }
    .btn-primary{
      background:linear-gradient(135deg,#003366,#002B5C);
      border:none;
      box-shadow:0 6px 18px rgba(0,51,102,.35);
    }
    .btn-info{
      background:linear-gradient(135deg,#0ea5e9,#0369a1);
      border:none;
      box-shadow:0 6px 16px rgba(14,165,233,.35);
    }
    .btn-outline-brand{
      border-radius:999px;
      border:1px solid rgba(16,185,129,.45);
      color:#10b981;
    }
    .btn-outline-brand:hover{ background:rgba(16,185,129,.12); }
    .btn-danger{ background:rgba(239,68,68,.12); border:none; color:#ef4444; }
    .btn-danger:hover{ background:rgba(239,68,68,.22); }
    .btn-fw{ font-weight:600; }

    #tablaReportes{ border-collapse:separate!important; border-spacing:0 8px; }
    #tablaReportes thead th{
      background:#f8fafc!important;
      border:none!important;
      font-size:.78rem;
      text-transform:uppercase;
      letter-spacing:.05em;
      color:#475569;
      padding:.75rem;
      white-space:nowrap;
    }
    #tablaReportes tbody tr{
      background:#ffffff;
      box-shadow:0 6px 18px rgba(15,23,42,.06);
      transition:transform .18s ease, box-shadow .18s ease;
    }
    #tablaReportes tbody tr:hover{
      transform:translateY(-1px);
      box-shadow:0 14px 32px rgba(15,23,42,.12);
    }
    #tablaReportes tbody td{
      border:none!important;
      vertical-align:middle;
      padding:.65rem .75rem;
      font-size:.9rem;
      color:#1e293b;
    }
    #tablaReportes tbody td:first-child{ font-weight:600; color:#2563eb; }

    .filters-row{
      background:#ffffff;
      border-radius:16px;
      padding:.85rem 1rem;
      box-shadow:0 8px 22px rgba(15,23,42,.05);
    }

    .modal-content{
      border-radius:20px!important;
      box-shadow:0 24px 48px rgba(15,23,42,.25);
    }
    .modal-header, .modal-footer{ border-color:rgba(0,0,0,.05); }

    .form-control, .custom-select{
      border-radius:12px;
      font-size:.9rem;
      transition:border-color .15s ease, box-shadow .15s ease;
    }
    .form-control:focus, .custom-select:focus{
      border-color:#2563eb;
      box-shadow:0 0 0 3px rgba(37,99,235,.18);
    }

    /* ===== FOTO UX ===== */
    .photo-card{
      border:1px dashed rgba(15,23,42,.18);
      border-radius:16px;
      padding:12px;
      background:linear-gradient(180deg,#fff,#fbfdff);
    }
    .photo-preview{
      width:100%;
      height:160px;
      border-radius:14px;
      border:1px solid rgba(0,0,0,.06);
      background:#f8fafc;
      display:flex;
      align-items:center;
      justify-content:center;
      overflow:hidden;
    }
    .photo-preview img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }
    .photo-empty{
      font-size:.85rem;
      color:#64748b;
      text-align:center;
      padding:10px;
    }
    .photo-meta{
      font-size:.8rem;
      color:#64748b;
      margin-top:8px;
      line-height:1.2;
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
            <i class="fas fa-bars fa-lg"></i>
          </a>
        </li>
        <li class="nav-item d-flex align-items-center ml-2">
          <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width:25px;height:25px;">
        </li>
      </ul>

      <ul class="navbar-nav ml-auto d-flex align-items-center">
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
              <p class="text-muted small mb-0">Usuario activo</p>
            </div>
            @if(Auth::user()->esSupervisorMantenimiento())
              <div class="dropdown-divider"></div>
              <a class="dropdown-item d-flex align-items-center px-3 py-2" href="#" data-toggle="modal" data-target="#modalConfigurarFirma">
                <i class="fas fa-signature mr-2"></i> <span>Configurar mi firma</span>
              </a>
            @endif
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

        @if(Auth::user()->puedeVerMantenimiento())
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
        @endif

        <li class="nav-item">
          <a href="{{ route('boletas.index') }}" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar" style="color: var(--brand-accent);"></i>
            <p class="ml-2 mb-0">{{ Auth::user()->puedeGestionarBoletas() ? 'Gestionar Boletas' : 'Mis Boletas' }}</p>
          </a>
        </li>

          @if(Auth::user()->tieneAccesoCompleto())
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
              <p class="ms-2 mb-0">ROP2026 LOTE IX</p>
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
            <h3 class="card-title m-0 heading-font" style="color:#333;">Registrar nuevo reporte</h3>
            <button class="btn btn-brand btn-fw mt-2 mt-sm-0" data-toggle="modal" data-target="#modalAgregar">
              <i class="fas fa-plus mr-1"></i> Agregar Registro
            </button>
          </div>
        </div>
      </div>

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

      <div class="card card-clean">
        <div class="card-header bg-white border-bottom d-flex justify-content-center align-items-center">
          <h3 class="card-title mb-0 heading-font" style="color:#333;">📋 REPORTES DE MANTENIMIENTO MECÁNICO 2025-2026</h3>
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

                      @if(!Auth::user()->esSoloMantenimiento())
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
                      @endif

                      @if(Auth::user()->esSupervisorMantenimiento())
                        @if($reporte->firmado_supervisor_id)
                          <span class="badge badge-success" title="Firmado el {{ $reporte->firmado_supervisor_en->format('d/m/Y H:i') }}">
                            <i class="fas fa-check-circle mr-1"></i> Firmado
                          </span>
                        @else
                          <button type="button" class="btn btn-sm btn-primary btn-fw" data-toggle="modal" data-target="#modalFirmar{{ $reporte->id }}">
                            <i class="fas fa-signature mr-1"></i> Firmar
                          </button>
                        @endif
                      @endif
                    </td>
                  </tr>
                @empty
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="px-3 py-2 text-right">
            <span class="text-muted">Total de reportes: <strong>{{ $totalReportes }}</strong></span>
          </div>
        </div>
      </div>
    </div>
    <a href="{{ route('reportes.backup.excel') }}"
      class="btn btn-success shadow-sm mb-3">
      <i class="fas fa-file-excel mr-1"></i> Backup Excel
    </a>
  </div>

  <footer class="main-footer text-center">
    <strong>Unienergia ABC © 2025</strong> Todos los derechos reservados.
  </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

@if(Auth::user()->esSupervisorMantenimiento())
<!-- ========== Modal Configurar Firma (Supervisor) ========== -->
<div class="modal fade" id="modalConfigurarFirma" tabindex="-1" role="dialog" aria-labelledby="modalConfigurarFirmaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form id="formConfigurarFirma" method="POST" action="{{ route('firma.guardar') }}" novalidate>
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalConfigurarFirmaLabel" style="color:#333;">
            ✍️ Configurar mi firma
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if(Auth::user()->firma_imagen)
            <div class="mb-3">
              <label class="font-weight-bold d-block">Firma actual guardada:</label>
              <img src="{{ asset('storage/'.Auth::user()->firma_imagen) }}" alt="Firma actual" style="max-height:80px;border:1px solid rgba(0,0,0,.1);border-radius:8px;padding:6px;background:#fff;">
              <div class="text-muted small mt-1">Si dibujas y guardas de nuevo, esta firma se reemplaza.</div>
            </div>
          @endif

          <div class="signature-card mb-3">
            <div class="signature-head">
              <div>
                <p class="signature-title">Dibuja tu firma</p>
                <p class="signature-hint">Con mouse o pantalla táctil.</p>
              </div>
            </div>
            <div class="signature-wrap">
              <canvas id="firmaCanvasSupervisor" class="signature-canvas"></canvas>
            </div>
            <input type="hidden" name="firma_data" id="firmaDataSupervisor">
            <div class="signature-actions mt-2">
              <button type="button" class="btn btn-outline-secondary btn-sm" id="firmaClearSupervisor">Limpiar</button>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Clave de firma (mínimo 4 caracteres)</label>
              <input type="password" name="pin" class="form-control shadow-sm" minlength="4" required autocomplete="new-password">
              <small class="text-muted">Se te pedirá cada vez que firmes un reporte. No es tu contraseña de acceso.</small>
            </div>
            <div class="col-md-6 mb-3">
              <label>Confirmar clave de firma</label>
              <input type="password" name="pin_confirmation" class="form-control shadow-sm" minlength="4" required autocomplete="new-password">
            </div>
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-brand btn-fw">
            <i class="fas fa-save mr-1"></i> Guardar firma
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endif

<!-- ========== Modales Editar (con FOTO) ========== -->
@foreach($reportes as $reporte)
<div class="modal fade" id="editarModal{{ $reporte->id }}" tabindex="-1" role="dialog" aria-labelledby="editarLabel{{ $reporte->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <!-- ✅ enctype necesario -->
    <form method="POST" action="{{ route('reportes.update', $reporte->id) }}" enctype="multipart/form-data">
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

            <!-- FOTO (preview + subir) -->
            <div class="col-md-12 mb-3">
              <div class="photo-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="mb-0 font-weight-bold">
                    <i class="fas fa-camera mr-1"></i> Evidencia fotográfica
                  </label>
                  <small class="text-muted">JPG / PNG / WEBP • Máx. 4MB</small>
                </div>

                <div class="row">
                  <div class="col-md-5 mb-2 mb-md-0">
                    <div class="photo-preview" id="previewWrap_edit_{{ $reporte->id }}">
                      @if($reporte->foto)
                        <img id="previewImg_edit_{{ $reporte->id }}" src="{{ asset('storage/'.$reporte->foto) }}" alt="Foto evidencia">
                      @else
                        <div class="photo-empty" id="previewEmpty_edit_{{ $reporte->id }}">
                          Sin foto. Sube una imagen para evidenciar el reporte.
                        </div>
                        <img id="previewImg_edit_{{ $reporte->id }}" src="" alt="Previsualización" style="display:none;">
                      @endif
                    </div>
                    @if($reporte->foto)
                      <div class="photo-meta">
                        <i class="far fa-image mr-1"></i>
                        Archivo: <span class="text-dark">{{ basename($reporte->foto) }}</span>
                      </div>
                    @endif
                  </div>

                  <div class="col-md-7">
                    <input type="file"
                           name="foto"
                           class="form-control"
                           accept="image/*"
                           onchange="previewFoto(event, 'edit', {{ $reporte->id }})">

                    <div class="photo-meta">
                      Si subes una nueva foto, reemplazará la anterior automáticamente.
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- RESTO CAMPOS -->
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
        <!-- FIRMA RESPONSABLE (EDIT) -->
        <div class="col-md-12 mb-3">
          <div class="signature-card">
            <div class="signature-head">
              <div>
                <p class="signature-title">Firma del Personal Responsable</p>
                <p class="signature-hint">Si necesita actualizar la firma, firme nuevamente y confirme.</p>
              </div>
              @if(!empty($reporte->firma))
                <span class="badge badge-success">Con firma</span>
              @else
                <span class="badge badge-warning">Sin firma</span>
              @endif
            </div>

            @if(!empty($reporte->firma))
              <div style="margin-bottom:10px; text-align:center;">
                <img
                  src="{{ asset('storage/'.$reporte->firma) }}"
                  alt="Firma guardada"
                  style="max-height:70px; max-width:100%; border:1px solid rgba(0,0,0,.15); border-radius:10px; padding:6px; background:#fff;"
                >
              </div>
            @endif
          <div class="signature-wrap">
            <canvas id="firmaCanvasEdit{{ $reporte->id }}" class="signature-canvas"></canvas>
          </div>

          <input type="hidden" name="firma_data" id="firmaDataEdit{{ $reporte->id }}">

          <div class="signature-actions mt-2">
            <button type="button" class="btn btn-outline-secondary btn-sm firma-clear" data-id="{{ $reporte->id }}">
              Limpiar
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm firma-save" data-id="{{ $reporte->id }}">
              Confirmar firma
            </button>
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

@if(Auth::user()->esSupervisorMantenimiento() && !$reporte->firmado_supervisor_id)
<!-- Modal Firmar (Supervisor) -->
<div class="modal fade" id="modalFirmar{{ $reporte->id }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('reportes.firmar', $reporte->id) }}">
      @csrf
      @method('PATCH')
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" style="color:#333;">
            ✍️ Firmar Reporte de {{ $reporte->nombre }}
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if(empty(Auth::user()->firma_pin) || empty(Auth::user()->firma_imagen))
            <div class="alert alert-warning mb-0">
              Todavía no configuras tu firma. Ve a tu menú de usuario y elige <strong>"Configurar mi firma"</strong> antes de firmar reportes.
            </div>
          @else
            <label>Ingresa tu clave de firma</label>
            <input type="password" name="pin" class="form-control shadow-sm" required autocomplete="current-password" autofocus>
          @endif
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          @if(!empty(Auth::user()->firma_pin) && !empty(Auth::user()->firma_imagen))
            <button type="submit" class="btn btn-brand btn-fw">
              <i class="fas fa-signature mr-1"></i> Confirmar Firma
            </button>
          @endif
        </div>
      </div>
    </form>
  </div>
</div>
@endif
@endforeach

<!-- ========== Modal Agregar (con FOTO optimizada) ========== -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

    <form id="formAgregarReporte" method="POST" action="{{ route('reportes.store') }}" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarLabel" style="color:#333;">
            🛠️ Nuevo Reporte de Mantenimiento
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- Zona mensajes -->
          <div id="msgFormNew" class="alert alert-danger d-none"></div>

          <div class="form-row">

            <!-- FOTO -->
            <div class="col-md-12 mb-3">
              <div class="photo-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <label class="mb-0 font-weight-bold">
                    <i class="fas fa-camera mr-1"></i> Evidencia fotográfica
                  </label>
                  <small class="text-muted">JPG / PNG / WEBP / HEIC • Se optimiza automáticamente</small>
                </div>

                <div class="row">
                  <div class="col-md-5 mb-2 mb-md-0">
                    <div class="photo-preview" id="previewWrap_new">
                      <div class="photo-empty" id="previewEmpty_new">
                        Sin foto. Sube una imagen para evidenciar el reporte.
                      </div>
                      <img id="previewImg_new" src="" alt="Previsualización" style="display:none;max-width:100%;border-radius:10px;">
                    </div>
                    <small class="text-muted d-block mt-2" id="photoInfoNew"></small>
                  </div>

                  <div class="col-md-7">
                    <input
                      id="foto_new"
                      type="file"
                      name="foto"
                      class="form-control"
                      accept="image/jpeg,image/png,image/webp,image/heic,image/heif,image/*"
                      >

                    <div class="text-muted small mt-2">
                      Recomendación: foto horizontal, enfocando el equipo y rotulado si aplica.
                      <br>
                      * Si la imagen es grande, el sistema la convierte/optimiza para asegurar el guardado.
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- RESTO CAMPOS -->
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

          <!-- FIRMA RESPONSABLE -->
          <div class="col-md-12 mb-3">
            <div class="signature-card">
              <div class="signature-head">
                <div>
                  <p class="signature-title">Firma del Personal Responsable</p>
                  <p class="signature-hint">Firme con mouse o pantalla táctil. Luego guarde el reporte.</p>
                </div>
                <span class="badge badge-light">Obligatorio</span>
              </div>

              <div class="signature-wrap">
                <canvas id="firmaCanvasNew" class="signature-canvas"></canvas>
              </div>

              <input type="hidden" name="firma_data" id="firmaDataNew">

              <div class="signature-actions mt-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="firmaClearNew">Limpiar</button>
                <button type="button" class="btn btn-outline-primary btn-sm" id="firmaSaveNew">Confirmar firma</button>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button id="btnGuardarNew" type="submit" class="btn btn-brand btn-fw">
            <i class="fas fa-save mr-1"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>



<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>



<script>
/** ===== Helpers ===== */
function bytesToMB(bytes){ return (bytes / (1024*1024)).toFixed(2); }

function showMsgNew(msg){
  const box = document.getElementById('msgFormNew');
  box.textContent = msg;
  box.classList.remove('d-none');
}
function clearMsgNew(){
  const box = document.getElementById('msgFormNew');
  box.textContent = '';
  box.classList.add('d-none');
}

function setPreviewNew(file){
  const empty = document.getElementById('previewEmpty_new');
  const img = document.getElementById('previewImg_new');
  const info = document.getElementById('photoInfoNew');

  empty.style.display = 'none';
  img.style.display = 'block';
  img.src = URL.createObjectURL(file);
  info.textContent = `${file.type || 'imagen'} • ${bytesToMB(file.size)} MB`;
}

/**
 * Comprime/convierte a JPEG para evitar fallos por tamaño.
 * - maxDim: 1920 (calidad operativa)
 * - quality: 0.82 (equilibrio)
 */
async function compressToJpeg(file, maxDim = 1920, quality = 0.82){
  // Algunos navegadores no soportan createImageBitmap para ciertos formatos (ej HEIC)
  // En esos casos, lo dejamos pasar y lo guardará el backend (si lo soporta).
  let bitmap;
  try{
    bitmap = await createImageBitmap(file);
  }catch(e){
    return file; // fallback: no se pudo leer; no rompemos el flujo.
  }

  const w = bitmap.width;
  const h = bitmap.height;
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

/**
 * Reemplaza el file del input por el optimizado (sin tocar backend)
 */
function replaceInputFile(input, file){
  const dt = new DataTransfer();
  dt.items.add(file);
  input.files = dt.files;
}

/**
 * Prepara una foto para envío:
 * - Si pesa mucho o es PNG, la comprime/convierte a JPEG (evita 413 del servidor).
 * - Si no hace falta comprimir, igual la "clona" a memoria (arrayBuffer -> File nuevo)
 *   para fijar sus bytes ya y evitar que el navegador pierda acceso al archivo
 *   original (error ERR_UPLOAD_FILE_CHANGED) si pasa tiempo entre elegir la foto
 *   y enviar el formulario (ej: mientras se firma).
 */
async function prepararFotoParaEnvio(file, maxDim = 1920, quality = 0.82){
  const shouldCompress = (file.size > 1.5 * 1024 * 1024) || (file.type === 'image/png');

  if (shouldCompress) {
    return await compressToJpeg(file, maxDim, quality);
  }

  try {
    const buf = await file.arrayBuffer();
    return new File([buf], file.name || 'foto', { type: file.type, lastModified: Date.now() });
  } catch (e) {
    return file; // fallback: si algo falla, se envía el original
  }
}

/** ===== Estado global (evita submit antes de terminar compresión) ===== */
let fotoProcessingPromise = null;

/** ===== Init ===== */
document.addEventListener('DOMContentLoaded', () => {
  const inputFoto = document.getElementById('foto_new');
  const form = document.getElementById('formAgregarReporte');
  const btnGuardar = document.getElementById('btnGuardarNew');

  // 1) Foto: preview + optimización
  inputFoto.addEventListener('change', () => {
    clearMsgNew();
    const file = inputFoto.files && inputFoto.files[0];
    if(!file) return;

    // Validación básica de tipo (permitimos image/*, pero filtramos lo más común)
    if(!file.type.startsWith('image/')){
      inputFoto.value = '';
      showMsgNew('El archivo seleccionado no es una imagen válida.');
      return;
    }

    // Mostrar preview inicial
    setPreviewNew(file);

    // Comprimimos/clonamos SIEMPRE antes de enviar
    fotoProcessingPromise = (async () => {
      const optimized = await prepararFotoParaEnvio(file);

      // Reemplazar input y actualizar preview con el archivo ya "fijado" en memoria
      if(optimized && optimized !== file){
        replaceInputFile(inputFoto, optimized);
        setPreviewNew(optimized);
      }
    })();
  });

  // 2) Firma: si no le dan "Confirmar", capturamos igual en submit
  function captureSignatureIfAny(){
    const canvas = document.getElementById('firmaCanvasNew');
    const hidden = document.getElementById('firmaDataNew');
    if(!canvas || !hidden) return true;

    // Detecta canvas vacío (técnica simple)
    const ctx = canvas.getContext('2d');
    const pixels = ctx.getImageData(0,0,canvas.width,canvas.height).data;
    let hasInk = false;
    for(let i=3; i<pixels.length; i+=4){
      if(pixels[i] !== 0){ hasInk = true; break; } // alpha != 0
    }

    if(!hasInk){
      showMsgNew('La firma es obligatoria. Por favor, firme antes de guardar.');
      return false;
    }

    // Guardar firma en base64 PNG
    hidden.value = canvas.toDataURL('image/png');
    return true;
  }

  // Si el usuario presiona “Confirmar firma”
  const btnFirmaSave = document.getElementById('firmaSaveNew');
  if(btnFirmaSave){
    btnFirmaSave.addEventListener('click', () => {
      clearMsgNew();
      const ok = captureSignatureIfAny();
      if(ok) {
        // feedback opcional
        // showMsgNew('Firma confirmada correctamente.');
        document.getElementById('msgFormNew').classList.add('d-none');
      }
    });
  }

  // 3) Submit: espera compresión + firma + bloqueo doble submit
  form.addEventListener('submit', async (e) => {
    clearMsgNew();

    // Evita doble submit
    if(btnGuardar.dataset.loading === '1'){
      e.preventDefault();
      return;
    }

    // Esperar foto (si se está procesando)
    if(fotoProcessingPromise){
      btnGuardar.disabled = true;
      btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
      try{
        await fotoProcessingPromise;
      }catch(err){
        // si algo falla, igual intentamos enviar sin bloquear al usuario
      }
    }

    // Firma obligatoria
    const okFirma = captureSignatureIfAny();
    if(!okFirma){
      e.preventDefault();
      btnGuardar.disabled = false;
      btnGuardar.innerHTML = '<i class="fas fa-save mr-1"></i> Guardar';
      return;
    }

    // Bloquear botón para evitar doble click
    btnGuardar.dataset.loading = '1';
    btnGuardar.disabled = true;
    btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...';
  });

});
</script>











<script>
  // Guardamos instancias para NO recrearlas (precisión)
  const signaturePads = new Map();

  function resizeCanvasForSignaturePad(canvas, pad) {
    // Tamaño real visible
    const rect = canvas.getBoundingClientRect();
    if (!rect.width || !rect.height) return;

    // Retina scaling
    const ratio = Math.max(window.devicePixelRatio || 1, 1);

    // Guardar trazo para no perderlo (opcional)
    const data = pad && !pad.isEmpty() ? pad.toData() : null;

    canvas.width  = Math.round(rect.width * ratio);
    canvas.height = Math.round(rect.height * ratio);

    const ctx = canvas.getContext("2d");
    ctx.setTransform(ratio, 0, 0, ratio, 0, 0); // escalado preciso

    if (pad) {
      pad.clear();
      if (data) pad.fromData(data);
    }
  }

  function initPad(canvasId, hiddenId) {
    const canvas = document.getElementById(canvasId);
    const hidden = document.getElementById(hiddenId);
    if (!canvas || !hidden) return null;

    // Si ya existe, reutiliza
    if (signaturePads.has(canvasId)) {
      const pad = signaturePads.get(canvasId);
      resizeCanvasForSignaturePad(canvas, pad);
      return pad;
    }

    const pad = new SignaturePad(canvas, {
      minWidth: 0.8,
      maxWidth: 2.2,
      penColor: "#0f172a",
      throttle: 0,     // más precisión (menos suavizado raro)
      minDistance: 0,  // registra movimientos pequeños
    });

    signaturePads.set(canvasId, pad);
    resizeCanvasForSignaturePad(canvas, pad);

    // Cada vez que el usuario dibuja, puedes auto-guardar (opcional)
    // pad.onEnd = () => { hidden.value = pad.toDataURL("image/png"); };

    return pad;
  }

  // --- NUEVO (AGREGAR) ---
  function wireNewSignature() {
    const pad = initPad("firmaCanvasNew", "firmaDataNew");
    if (!pad) return;

    document.getElementById("firmaClearNew")?.addEventListener("click", () => {
      pad.clear();
      document.getElementById("firmaDataNew").value = "";
    });

    document.getElementById("firmaSaveNew")?.addEventListener("click", () => {
      if (pad.isEmpty()) { alert("Firme antes de confirmar."); return; }
      document.getElementById("firmaDataNew").value = pad.toDataURL("image/png");
    });
  }

  // --- EDITAR (por id) ---
  function wireEditSignature(id) {
    const canvasId = "firmaCanvasEdit" + id;
    const hiddenId = "firmaDataEdit" + id;

    const pad = initPad(canvasId, hiddenId);
    if (!pad) return;

    document.querySelector(`.firma-clear[data-id="${id}"]`)?.addEventListener("click", () => {
      pad.clear();
      document.getElementById(hiddenId).value = "";
    });

    document.querySelector(`.firma-save[data-id="${id}"]`)?.addEventListener("click", () => {
      if (pad.isEmpty()) { alert("Firme antes de confirmar."); return; }
      document.getElementById(hiddenId).value = pad.toDataURL("image/png");
    });
  }

  // --- CONFIGURAR FIRMA (Supervisor) ---
  function wireFirmaSupervisor() {
    const pad = initPad("firmaCanvasSupervisor", "firmaDataSupervisor");
    if (!pad) return;

    document.getElementById("firmaClearSupervisor")?.addEventListener("click", () => {
      pad.clear();
      document.getElementById("firmaDataSupervisor").value = "";
    });

    const form = document.getElementById("formConfigurarFirma");
    if (form && !form.dataset.wired) {
      form.dataset.wired = "1";
      form.addEventListener("submit", (e) => {
        if (pad.isEmpty()) {
          e.preventDefault();
          alert("Dibuja tu firma antes de guardar.");
          return;
        }
        document.getElementById("firmaDataSupervisor").value = pad.toDataURL("image/png");
      });
    }
  }

  // IMPORTANTE: Inicializar cuando el modal YA está visible
  $('#modalAgregar').on('shown.bs.modal', function () {
    wireNewSignature();
    // Recalibrar al abrir (precisión)
    const pad = signaturePads.get("firmaCanvasNew");
    if (pad) resizeCanvasForSignaturePad(document.getElementById("firmaCanvasNew"), pad);
  });

  $('#modalConfigurarFirma').on('shown.bs.modal', function () {
    wireFirmaSupervisor();
    const pad = signaturePads.get("firmaCanvasSupervisor");
    if (pad) resizeCanvasForSignaturePad(document.getElementById("firmaCanvasSupervisor"), pad);
  });

  // Para modales de editar (muchos)
  $(document).on('shown.bs.modal', '.modal', function () {
    const modalId = this.getAttribute("id") || "";
    // tu id ejemplo: editarModal12 -> extraer 12
    const match = modalId.match(/editarModal(\d+)/);
    if (match) {
      const id = match[1];
      wireEditSignature(id);
      const canvasId = "firmaCanvasEdit" + id;
      const pad = signaturePads.get(canvasId);
      if (pad) resizeCanvasForSignaturePad(document.getElementById(canvasId), pad);
    }
  });

  // Recalibrar si cambias tamaño ventana
  window.addEventListener("resize", () => {
    signaturePads.forEach((pad, canvasId) => {
      const canvas = document.getElementById(canvasId);
      if (canvas) resizeCanvasForSignaturePad(canvas, pad);
    });
  });
</script>


<script>
  // Foto pendiente de comprimir/clonar por formulario de edición (evita 413 y ERR_UPLOAD_FILE_CHANGED)
  const fotoProcessingPorForm = new WeakMap();

  function previewFoto(event, mode, id) {
    const input = event.target;
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    if (!file.type || !file.type.startsWith('image/')) {
      input.value = '';
      alert('El archivo seleccionado no es una imagen válida.');
      return;
    }

    const url = URL.createObjectURL(file);

    if (mode === 'new') {
      const img = document.getElementById('previewImg_new');
      const empty = document.getElementById('previewEmpty_new');
      if (empty) empty.style.display = 'none';
      img.src = url;
      img.style.display = 'block';
      return;
    }

    // edit
    const img = document.getElementById('previewImg_edit_' + id);
    const empty = document.getElementById('previewEmpty_edit_' + id);

    if (empty) empty.style.display = 'none';
    img.src = url;
    img.style.display = 'block';

    // Comprimimos/clonamos la foto ya, para no depender del archivo original
    // (que puede quedar inválido si pasa tiempo antes de enviar, ej. al firmar).
    const form = input.closest('form');
    if (form && typeof prepararFotoParaEnvio === 'function') {
      const processing = prepararFotoParaEnvio(file).then((optimized) => {
        if (optimized && optimized !== file) {
          replaceInputFile(input, optimized);
          img.src = URL.createObjectURL(optimized);
        }
      });
      fotoProcessingPorForm.set(form, processing);
    }
  }

  // Antes de enviar cualquier formulario de edición, esperar a que la foto
  // termine de comprimirse/clonarse (si aplica).
  document.addEventListener('submit', function (e) {
    const form = e.target;
    const pending = fotoProcessingPorForm.get(form);
    if (!pending) return;

    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    if (btn) { btn.disabled = true; }

    pending.finally(() => {
      fotoProcessingPorForm.delete(form);
      if (btn) { btn.disabled = false; }
      form.requestSubmit ? form.requestSubmit() : form.submit();
    });
  }, true);

  $(function () {
    $('#notificacionesDropdown').on('click', function () { $('#notiBadge').hide(); });

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
