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
          <h3 class="card-title mb-0 heading-font" style="color:#333;">📋 REPORTES DE MANTENIMIENTO MECÁNICO 2025</h3>
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
@endforeach

<!-- ========== Modal Agregar (con FOTO) ========== -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <!-- ✅ enctype necesario -->
    <form method="POST" action="{{ route('reportes.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarLabel" style="color:#333;">🛠️ Nuevo Reporte de Mantenimiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
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
                    <div class="photo-preview" id="previewWrap_new">
                      <div class="photo-empty" id="previewEmpty_new">
                        Sin foto. Sube una imagen para evidenciar el reporte.
                      </div>
                      <img id="previewImg_new" src="" alt="Previsualización" style="display:none;">
                    </div>
                  </div>

                  <div class="col-md-7">
                    <input type="file"
                           name="foto"
                           class="form-control"
                           accept="image/*"
                           onchange="previewFoto(event, 'new')">

                    <div class="photo-meta">
                      Recomendación: foto horizontal, enfocando el equipo y rotulado si aplica.
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
              <button type="button" class="btn btn-outline-secondary btn-sm" id="firmaClearNew">
                Limpiar
              </button>
              <button type="button" class="btn btn-outline-primary btn-sm" id="firmaSaveNew">
                Confirmar firma
              </button>
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



<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

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

  // IMPORTANTE: Inicializar cuando el modal YA está visible
  $('#modalAgregar').on('shown.bs.modal', function () {
    wireNewSignature();
    // Recalibrar al abrir (precisión)
    const pad = signaturePads.get("firmaCanvasNew");
    if (pad) resizeCanvasForSignaturePad(document.getElementById("firmaCanvasNew"), pad);
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
  function previewFoto(event, mode, id) {
    const input = event.target;
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
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
  }

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
