<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Requerimientos - Sistema Integrado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 coherentes -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- DataTables (Bootstrap 4 + Responsive) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

  <!-- Fuente títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <style>
    /* ===== Paleta corporativa ===== */
    :root{
      --brand-primary: #003366;      /* azul corporativo */
      --brand-primary-dark: #002B5C;
      --brand-accent: #00A86B;       /* verde acento */
      --brand-accent-dark: #038b5a;
      --brand-info: #17a2b8;
      --sidebar-bg: #121212;
      --sidebar-main: #1F1F1F;
      --text-on-brand: #ffffff;
    }

    .heading-font { font-family:'Montserrat',sans-serif; }
        /* Evitar que el usuario cambie el tamaño del textarea */
    .no-resize { resize: none !important; }

    /* Un poco más alto de lo usual (mejor lectura/escritura) */
    .tall-textarea { min-height: 70px; }
    /* Navbar */
    .navbar-uni { background: var(--brand-primary); box-shadow:0 2px 4px rgba(0,0,0,.2); }
    .navbar-uni .nav-link { color:#fff; }
    .navbar-uni .nav-link:hover { opacity:.9; }

    /* Sidebar */
    .main-sidebar { background-color: var(--sidebar-main)!important; }
    .brand-area { background-color: var(--sidebar-bg); }
    .brand-area .brand-text { color:#fff; }
    .nav-sidebar .nav-link { color:#eaeaea!important; border-radius:.35rem; margin:0 .25rem; }
    .nav-sidebar .nav-link.active{
      background: linear-gradient(90deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color:#fff!important;
    }
    .nav-sidebar .nav-link:hover{ background-color: rgba(255,255,255,.08)!important; color:#fff!important; }
    .nav-icon.text-info{ color: var(--brand-info)!important; }
    .nav-icon.text-success{ color: var(--brand-accent)!important; }

    /* Botones corporativos */
    .btn-brand { background: var(--brand-accent); border-color: var(--brand-accent); color:#fff; }
    .btn-brand:hover { background: var(--brand-accent-dark); border-color: var(--brand-accent-dark); color:#fff; }
    .btn-outline-brand { border-color: var(--brand-accent); color: var(--brand-accent); }
    .btn-outline-brand:hover { background: var(--brand-accent); color:#fff; }
    .btn-primary { background: var(--brand-primary); border-color: var(--brand-primary); }
    .btn-primary:hover { background: var(--brand-primary-dark); border-color: var(--brand-primary-dark); }

    /* Cards */
    .card-clean { border:1px solid rgba(0,0,0,.06); box-shadow: 0 2px 10px rgba(0,0,0,.04); }

    /* DataTable */
    table.dataTable thead th{ white-space: nowrap; }
    .table thead th{ font-weight:600; }

    /* Acciones wrap */
    .actions-wrap { display:inline-flex; gap:.25rem; flex-wrap:wrap; justify-content:center; }

    /* Ajustes tabla principal */
    #tablaRequerimientos td, #tablaRequerimientos th { white-space: nowrap; }
    @media (max-width:576px){
      #tablaRequerimientos td:nth-child(3),
      #tablaRequerimientos td:nth-child(4){ white-space: normal; }
    }

    /* ===== Modal móvil (BS4) ===== */
    @media (max-width: 576px) {
      #modalAgregar .modal-dialog{
        width:100%!important; max-width:100%!important; margin:0!important;
        height:100%!important; display:flex; flex-direction:column;
      }
      #modalAgregar .modal-content{
        border-radius:0!important; height:100vh!important; display:flex; flex-direction:column;
      }
      #modalAgregar .modal-header{ position:sticky; top:0; z-index:3; background:#fff; }
      #modalAgregar .modal-footer{ position:sticky; bottom:0; z-index:3; background:#fff; }
      #modalAgregar .modal-body{
        overflow-y:auto; -webkit-overflow-scrolling:touch;
        padding: 1rem .75rem 4.5rem;
      }
      #modalAgregar .btn{ padding:.6rem .85rem; }
      #modalAgregar .input-group-text{ min-width:2.5rem; justify-content:center; }
    }

    /* Secciones del modal */
    #modalAgregar .form-section{
      background:#fff; border:1px solid rgba(0,0,0,.05);
      border-radius:.5rem; box-shadow:0 2px 6px rgba(0,0,0,.04);
      margin-bottom:.85rem; padding:1rem;
    }
    #wrapTablaDetalles{ overflow-x:auto; -webkit-overflow-scrolling:touch; }
    @media (max-width:576px){ #modalAgregar .table-items{ font-size:.92rem; } }

  </style>
</head>
<body class="hold-transition sidebar-mini">

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
        <ul class="nav nav-pills nav-sidebar flex-column">
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
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="content-wrapper" style="background-color:#f8f9fa;">
    <div class="content-header py-3 border-bottom">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="m-0 font-weight-semibold heading-font" style="color:#333;">
          📋 Requerimientos, Operaciones Lote IX.
        </h1>
        <button class="btn btn-brand" data-toggle="modal" data-target="#modalAgregar">
          <i class="fas fa-plus mr-1"></i> Nuevo Requerimiento
        </button>
      </div>
    </div>

    {{-- Filtros --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="px-3 w-100">
        <form action="{{ route('requerimientos.index') }}" method="GET" class="form-row align-items-end">
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label for="filtro_codigo" class="mb-0 small text-muted">Código</label>
            <input type="text" id="filtro_codigo" name="codigo" class="form-control" placeholder="Ej: REQ-2025-001" value="{{ request('codigo') }}">
          </div>
          <div class="col-6 col-md-2 mb-2">
            <label for="fecha_filtro" class="mb-0 small text-muted">Fecha</label>
            <input type="date" id="fecha_filtro" name="fecha" class="form-control" value="{{ request('fecha') }}">
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label for="area_solicitante" class="mb-0 small text-muted">Área</label>
            @php
              $areas = ['Ingenieria de Produccion y Facilidades','HSE','Administracion','Logistica','Mantenimiento','Produccion'];
            @endphp
            <select name="area_solicitante" id="area_solicitante" class="form-control">
              <option value="">Todas</option>
              @foreach($areas as $area)
                <option value="{{ $area }}" {{ request('area_solicitante')===$area ? 'selected' : '' }}>{{ $area }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label for="nombre_solicitante" class="mb-0 small text-muted">Solicitante</label>
            <input type="text" id="nombre_solicitante" name="nombre_solicitante" class="form-control" placeholder="Nombre solicitante" value="{{ request('nombre_solicitante') }}">
          </div>
          <div class="col-6 col-md-1 mb-2">
            <button type="submit" class="btn btn-primary btn-block">
              <i class="fas fa-search mr-1"></i> Buscar
            </button>
          </div>
          <div class="col-6 col-md-1 mb-2">
            <a href="{{ route('requerimientos.index') }}" class="btn btn-outline-secondary btn-block">Limpiar</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card card-clean mt-3">
      <div class="card-header bg-white border-bottom text-center">
        <h3 class="card-title mb-0 font-weight-semibold heading-font" style="color:#333;">Lista de Requerimientos</h3>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="tablaRequerimientos" class="table table-hover table-bordered align-middle text-center" style="width:100%">
            <thead class="thead-light">
              <tr class="text-muted">
                <th data-priority="1">Código</th>
                <th data-priority="3">Fecha</th>
                <th data-priority="4">Área solicitante</th>
                <th data-priority="5">Solicitante</th>
                <th data-priority="6">Tipo</th>
                <th data-priority="2">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($requerimientos as $req)
                <tr>
                  <td>{{ $req->codigo }}</td>
                  <td>{{ \Carbon\Carbon::parse($req->fecha)->format('d/m/Y') }}</td>
                  <td>{{ $req->area_solicitante }}</td>
                  <td>{{ $req->nombre_solicitante }}</td>
                  <td>{{ $req->servicio }}</td>
                  <td>
                    <span class="actions-wrap">
                     <a href="{{ route('requerimientos.show', $req->id) }}"
                      class="btn btn-sm btn-outline-info"
                      title="Ver (PDF)" 
                      target="_blank" 
                      rel="noopener noreferrer">
                      <i class="fas fa-eye"></i>
                    </a>
                      {{-- Eliminar --}}
                      <form action="{{ route('requerimientos.destroy', $req->id) }}" method="POST" class="d-inline-block"
                            onsubmit="return confirm('¿Eliminar el requerimiento {{ $req->codigo }}? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </span>
                  </td>
                </tr>
              @empty
                {{-- DataTables mostrará "emptyTable" --}}
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-3 py-2 text-right">
          <span class="text-muted">Total de requerimientos: <strong>{{ $requerimientos->count() }}</strong></span>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © 2025</strong> Todos los derechos reservados.
  </footer>
</div>

<!-- ===== Modal Crear Requerimiento (BS4, responsive + UX) ===== -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
    <form method="POST" action="{{ route('requerimientos.store') }}" id="formCrearReq" novalidate>
      @csrf
      <div class="modal-content shadow-sm border-0" id="modalAgregarContent">
        <div class="modal-header bg-white border-bottom">
          <div class="d-flex flex-column">
            <h5 class="modal-title font-weight-semibold mb-0" id="modalAgregarLabel">📝 Nuevo Requerimiento</h5>
            <small class="text-muted">Complete los campos y añada los ítems necesarios</small>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <!-- Sección: Datos generales -->
          <div class="form-section">
            <div class="form-row">
              <div class="col-12 col-md-4 mb-3">
                <label for="codigo_modal" class="mb-1">Código</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hashtag"></i></span></div>
                  <input type="text" id="codigo_modal" name="codigo" class="form-control" value="{{ old('codigo') }}" required>
                </div>
                @error('codigo') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-6 col-md-4 mb-3">
                <label for="fecha_modal" class="mb-1">Fecha</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></div>
                  <input type="date" id="fecha_modal" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                </div>
                @error('fecha') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-6 col-md-4 mb-3">
                <label for="area_solicitante_modal" class="mb-1">Área solicitante</label>
                @php
                  $areas = ['Ingenieria de Produccion y Facilidades','HSE','Administracion','Logistica','Mantenimiento','Produccion'];
                  $areaActual = old('area_solicitante','');
                @endphp
                <select name="area_solicitante" id="area_solicitante_modal" class="form-control" required>
                  <option value="" disabled {{ $areaActual==='' ? 'selected' : '' }}>Seleccione…</option>
                  @foreach($areas as $area)
                    <option value="{{ $area }}" {{ $areaActual === $area ? 'selected' : '' }}>{{ $area }}</option>
                  @endforeach
                </select>
                @error('area_solicitante') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="nombre_solicitante_modal" class="mb-1">Nombre solicitante</label>
                <div class="input-group">
                  <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                  <input type="text" id="nombre_solicitante_modal" name="nombre_solicitante" class="form-control"
                         value="{{ old('nombre_solicitante', Auth::user()->name ?? '') }}" readonly required>
                </div>
                @error('nombre_solicitante') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="cargo_solicitante" class="mb-1">Cargo</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                  </div>
                  <input type="text" id="cargo_solicitante" name="cargo_solicitante" class="form-control"
                        value="{{ Auth::user()->cargo ?? '' }}" readonly required>
                </div>
                @error('cargo_solicitante')
                  <small class="text-danger d-block">{{ $message }}</small>
                @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label class="d-block mb-1">Destino</label>
                @php
                  $opDestinos = ['Lote IX','Oficina','Unidad vehicular','Vivienda'];
                  $seleccionados = old('destino', []);
                @endphp
                @foreach ($opDestinos as $i => $opt)
                  <div class="custom-control custom-checkbox custom-control-inline mb-1">
                    <input class="custom-control-input" type="checkbox" id="destino_{{ $i }}" name="destino[]" value="{{ $opt }}"
                           {{ in_array($opt, (array)$seleccionados) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="destino_{{ $i }}">{{ $opt }}@if(in_array($opt,['Lote IX','Unidad vehicular','Vivienda']))*@endif</label>
                  </div>
                @endforeach
                @error('destino') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

              <div class="col-12 col-md-6 mb-3">
                <label for="servicio_modal" class="mb-1">Requerimiento de</label>
                @php
                  $opciones = ['Compra','Servicio'];
                  $valorActual = old('servicio', '');
                @endphp
                <select name="servicio" id="servicio_modal" class="form-control" required>
                  <option value="" disabled {{ $valorActual==='' ? 'selected' : '' }}>Seleccione…</option>
                  @foreach ($opciones as $opt)
                    <option value="{{ $opt }}" {{ $valorActual === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                  @endforeach
                </select>
                @error('servicio') <small class="text-danger d-block">{{ $message }}</small> @enderror
              </div>

             <div class="col-12 mb-2">
              <label for="sustento" class="mb-1">Sustento</label>
              <textarea
                id="sustento"
                name="sustento"
                class="form-control no-resize tall-textarea"
                placeholder="Detalle breve del requerimiento..."
              >{{ old('sustento') }}</textarea>
              @error('sustento') <small class="text-danger d-block">{{ $message }}</small> @enderror
              <small class="form-text text-muted">Sea claro y conciso. Puede adjuntar detalles en los ítems.</small>
            </div>
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          </div>

          <!-- Sección: Ítems -->
          <div class="form-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
              <h6 class="mb-2 mb-sm-0">Ítems del requerimiento</h6>
              <div class="btn-group btn-group-sm" role="group" aria-label="Acciones ítems">
                <button type="button" id="btnAddItem" class="btn btn-outline-brand">
                  <i class="fas fa-plus mr-1"></i> Agregar ítem
                </button>
                <button type="button" id="btnClearItems" class="btn btn-outline-secondary">
                  <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
              </div>
            </div>

            <div id="wrapTablaDetalles" class="table-responsive">
              <table class="table table-sm table-bordered align-middle table-items" id="tablaDetalles">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th style="min-width:160px">Identificación</th>
                    <th style="min-width:100px">Cantidad</th>
                    <th style="min-width:120px">Unidad</th>
                    <th style="min-width:220px">Descripción</th>
                    <th style="width:70px">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $oldDetalles = old('detalles', [['identificacion'=>'','cantidad'=>'','unidad'=>'','descripcion'=>'']]);
                  @endphp
                  @foreach($oldDetalles as $idx => $d)
                    <tr>
                      <td><input type="text" name="detalles[{{ $idx }}][identificacion]" class="form-control form-control-sm" value="{{ $d['identificacion'] ?? '' }}" placeholder="Código o referencia"></td>
                      <td><input type="number" min="1" name="detalles[{{ $idx }}][cantidad]" class="form-control form-control-sm" value="{{ $d['cantidad'] ?? '' }}" placeholder="1"></td>
                      <td><input type="text" name="detalles[{{ $idx }}][unidad]" class="form-control form-control-sm" value="{{ $d['unidad'] ?? '' }}" placeholder="Ej: UN, KG"></td>
                      <td><input type="text" name="detalles[{{ $idx }}][descripcion]" class="form-control form-control-sm" value="{{ $d['descripcion'] ?? '' }}" required placeholder="Descripción del ítem"></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" data-toggle="tooltip" title="Eliminar fila">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @error('detalles') <small class="text-danger d-block">{{ $message }}</small> @enderror
            @error('detalles.*.descripcion') <small class="text-danger d-block">{{ $message }}</small> @enderror
          </div>
        </div>

        <div class="modal-footer bg-white">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-brand">
            <i class="fas fa-save mr-1"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
  @csrf
</form>

<!-- ===== Scripts (orden correcto para BS4/AdminLTE3) ===== -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- DataTables + Responsive (Bootstrap 4) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
  // Notificaciones: ocultar badge al abrir
  $(function(){ $('#notificacionesDropdown').on('click', function(){ $('#notiBadge').hide(); }); });

  // DataTable Responsive con prioridades
  $(function(){
    $('#tablaRequerimientos').DataTable({
      responsive: { details: { type: 'inline', target: 'tr' } },
      autoWidth: false,
      columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 },
        { responsivePriority: 3, targets: 1 },
        { responsivePriority: 4, targets: 2 },
        { responsivePriority: 5, targets: 3 },
        { responsivePriority: 6, targets: 4 },
      ],
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay requerimientos registrados."
      }
    });
  });

  // ===== JS del modal =====
  (function () {
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Autogrow Sustento
    var ta = document.getElementById('sustento');
    if (ta) {
      function autogrow(el){ el.style.height='auto'; el.style.height=(el.scrollHeight+2)+'px'; }
      ta.addEventListener('input', function(){ autogrow(ta); });
      setTimeout(function(){ autogrow(ta); }, 100);
    }

    // Tabla dinámica de detalles
    var $tbody = $('#tablaDetalles tbody');
    var idx = $tbody.find('tr').length;

    function addRow(data) {
      data = data || {};
      var html = `
        <tr>
          <td><input type="text" name="detalles[${idx}][identificacion]" class="form-control form-control-sm" value="${data.identificacion||''}" placeholder="Código o referencia"></td>
          <td><input type="number" min="1" name="detalles[${idx}][cantidad]" class="form-control form-control-sm" value="${data.cantidad||''}" placeholder="1"></td>
          <td><input type="text" name="detalles[${idx}][unidad]" class="form-control form-control-sm" value="${data.unidad||''}" placeholder="Ej: UN, KG"></td>
          <td><input type="text" name="detalles[${idx}][descripcion]" class="form-control form-control-sm" value="${data.descripcion||''}" required placeholder="Descripción del ítem"></td>
          <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" data-toggle="tooltip" title="Eliminar fila">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>`;
      $tbody.append(html);
      idx++;
    }

    $('#btnAddItem').on('click', function(){ addRow(); });

    $('#btnClearItems').on('click', function(){
      if(confirm('¿Limpiar todas las filas de ítems?')){
        $tbody.empty(); idx = 0; addRow();
      }
    });

    $tbody.on('click', '.btn-del-row', function(){
      var $rows = $tbody.find('tr');
      if ($rows.length > 1) $(this).closest('tr').remove();
    });

    // Enter en descripción agrega fila
    $tbody.on('keydown', 'input[name$="[descripcion]"]', function(e){
      if (e.key === 'Enter'){ e.preventDefault(); addRow(); }
    });

    // Reabrir si hubo validaciones con error
    @if ($errors->any())
      $('#modalAgregar').modal('show');
    @endif
  })();
</script>

</body>
</html>
