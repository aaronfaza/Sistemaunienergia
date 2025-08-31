<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Requerimientos - Sistema Integrado</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- DataTables (Bootstrap 4 + Responsive) -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">

  <style>
    /* Compactar inputs del detalle en el modal */
    #tablaDetalles input.form-control-sm { padding: .25rem .5rem; }
    #tablaDetalles th, #tablaDetalles td { vertical-align: middle; }

    /* Botonera de acciones envolvente en móviles */
    .actions-wrap {
      display: inline-flex;
      gap: .25rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Evitar cortes raros de celdas y permitir breaks en textos largos */
    #tablaRequerimientos td, #tablaRequerimientos th { white-space: nowrap; }
    @media (max-width: 576px) {
      #tablaRequerimientos td:nth-child(3),
      #tablaRequerimientos td:nth-child(4) { white-space: normal; }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand" style="background-color:#003366; box-shadow:0 2px 4px rgba(0,0,0,.2);">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item">
          <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
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
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded-pill shadow-sm text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false" style="background-color:#002b5c;">
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
            <a class="dropdown-item d-flex align-items-center gap-2 px-3 py-2 text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt mr-2"></i> <span>Cerrar sesión</span>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar elevation-4" style="background-color:#1F1F1F;">
    <a href="#" class="brand-link text-center" style="background-color:#121212;">
      <img src="{{ asset('img/logo.png.png') }}" style="width:25px;height:25px;margin-right:8px;">
      <span class="brand-text font-weight-bold text-white">UNIENERGIA ABC</span>
    </a>
    <div class="sidebar">
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
            <a href="{{ route('reportes.index') }}" class="nav-link text-white">
              <i class="nav-icon fas fa-tools text-success"></i>
              <p class="ml-2 mb-0">Mantenimiento</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('requerimientos.index') }}" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : 'text-white' }}">
              <i class="nav-icon fas fa-file-alt text-info"></i>
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
        <h1 class="m-0 font-weight-semibold" style="font-family:'Montserrat',sans-serif;color:#333;">
          📋 Requerimientos, Operaciones Lote IX.
        </h1>
        <!-- BS4 -->
        <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregar">
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
            <input type="text" id="filtro_codigo" name="codigo" class="form-control"
                   placeholder="Ej: REQ-2025-001" value="{{ request('codigo') }}">
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
                <option value="{{ $area }}" {{ request('area_solicitante')===$area ? 'selected' : '' }}>
                  {{ $area }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label for="nombre_solicitante" class="mb-0 small text-muted">Solicitante</label>
            <input type="text" id="nombre_solicitante" name="nombre_solicitante" class="form-control"
                   placeholder="Nombre solicitante" value="{{ request('nombre_solicitante') }}">
          </div>
          <div class="col-6 col-md-1 d-grid mb-2">
            <button type="submit" class="btn btn-success btn-block">
              <i class="fas fa-search mr-1"></i> Buscar
            </button>
          </div>
          <div class="col-6 col-md-1 d-grid mb-2">
            <a href="{{ route('requerimientos.index') }}" class="btn btn-outline-secondary btn-block">Limpiar</a>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm border-0 mt-3">
      <div class="card-header bg-white border-bottom text-center">
        <h3 class="card-title mb-0 font-weight-semibold" style="color:#333;">Lista de Requerimientos</h3>
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
              @foreach ($requerimientos as $req)
                <tr>
                  <td>{{ $req->codigo }}</td>
                  <td>{{ \Carbon\Carbon::parse($req->fecha)->format('d/m/Y') }}</td>
                  <td>{{ $req->area_solicitante }}</td>
                  <td>{{ $req->nombre_solicitante }}</td>
                  <td>{{ $req->servicio }}</td>
                  <td>
                    <span class="actions-wrap">
                      <a href="{{ route('requerimientos.show', $req->id) }}"
                         class="btn btn-sm btn-outline-info" title="Ver (PDF)">
                        <i class="fas fa-eye"></i>
                      </a>
                      <form action="{{ route('requerimientos.destroy', $req->id) }}"
                            method="POST" class="d-inline-block"
                            onsubmit="return confirm('¿Eliminar el requerimiento {{ $req->codigo }}? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </span>
                  </td>
                </tr>
              @endforeach
              {{-- Nota: no insertar filas con colspan; DataTables mostrará emptyTable --}}
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

<!-- Modal Crear Requerimiento (BS4) -->
<div class="modal fade" id="modalAgregar" tabindex="-1" role="dialog" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <form method="POST" action="{{ route('requerimientos.store') }}">
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title font-weight-semibold" id="modalAgregarLabel">📝 Nuevo Requerimiento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

        <div class="modal-body">
          <div class="form-row">
            <div class="col-12 col-md-4 mb-3">
              <label for="codigo_modal">Código</label>
              <input type="text" id="codigo_modal" name="codigo" class="form-control shadow-sm" value="{{ old('codigo') }}" required>
              @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-6 col-md-4 mb-3">
              <label for="fecha_modal">Fecha</label>
              <input type="date" id="fecha_modal" name="fecha" class="form-control shadow-sm" value="{{ old('fecha') }}" required>
              @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-6 col-md-4 mb-3">
              <label for="area_solicitante_modal">Área solicitante</label>
              @php
                $areas = ['Ingenieria de Produccion y Facilidades','HSE','Administracion','Logistica','Mantenimiento','Produccion'];
                $areaActual = old('area_solicitante','');
              @endphp
              <select name="area_solicitante" id="area_solicitante_modal" class="form-control shadow-sm" required>
                <option value="" disabled {{ $areaActual==='' ? 'selected' : '' }}>Seleccione…</option>
                @foreach($areas as $area)
                  <option value="{{ $area }}" {{ $areaActual === $area ? 'selected' : '' }}>{{ $area }}</option>
                @endforeach
              </select>
              @error('area_solicitante') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="nombre_solicitante_modal">Nombre solicitante</label>
              <input type="text" id="nombre_solicitante_modal" name="nombre_solicitante" class="form-control shadow-sm"
                     value="{{ old('nombre_solicitante', Auth::user()->name ?? '') }}" readonly required>
              @error('nombre_solicitante') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="cargo_solicitante">Cargo</label>
              <input type="text" id="cargo_solicitante" name="cargo_solicitante" class="form-control shadow-sm" value="{{ old('cargo_solicitante') }}" required>
              @error('cargo_solicitante') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label class="d-block">Destino</label>
              @php
                $opDestinos = ['Lote IX','Oficina','Unidad vehicular','Vivienda'];
                $seleccionados = old('destino', []);
              @endphp
              @foreach ($opDestinos as $i => $opt)
                <div class="form-check form-check-inline mb-1">
                  <input class="form-check-input" type="checkbox" id="destino_{{ $i }}" name="destino[]" value="{{ $opt }}"
                         {{ in_array($opt, (array)$seleccionados) ? 'checked' : '' }}>
                  <label class="form-check-label" for="destino_{{ $i }}">{{ $opt }}@if(in_array($opt,['Lote IX','Unidad vehicular','Vivienda']))*@endif</label>
                </div>
              @endforeach
              @error('destino') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 col-md-6 mb-3">
              <label for="servicio_modal">Requerimiento de:</label>
              @php
                $opciones = ['Compra','Servicio'];
                $valorActual = old('servicio', '');
              @endphp
              <select name="servicio" id="servicio_modal" class="form-control shadow-sm" required>
                <option value="" disabled {{ $valorActual==='' ? 'selected' : '' }}>Seleccione…</option>
                @foreach ($opciones as $opt)
                  <option value="{{ $opt }}" {{ $valorActual === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
              </select>
              @error('servicio') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-12 mb-3">
              <label for="sustento">Sustento</label>
              <textarea id="sustento" name="sustento" class="form-control shadow-sm" rows="3">{{ old('sustento') }}</textarea>
              @error('sustento') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- ÍTEMS DEL REQUERIMIENTO --}}
            <div class="col-12">
              <hr class="my-2">
              <h6 class="mb-2">Ítems del requerimiento</h6>

              <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle" id="tablaDetalles">
                  <thead class="thead-light">
                    <tr class="text-center">
                      <th style="width: 18%">Identificación</th>
                      <th style="width: 10%">Cantidad</th>
                      <th style="width: 12%">Unidad</th>
                      <th>Descripción</th>
                      <th style="width: 8%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $oldDetalles = old('detalles', [['identificacion'=>'','cantidad'=>'','unidad'=>'','descripcion'=>'']]);
                    @endphp
                    @foreach($oldDetalles as $idx => $d)
                      <tr>
                        <td><input type="text" name="detalles[{{ $idx }}][identificacion]" class="form-control form-control-sm" value="{{ $d['identificacion'] ?? '' }}"></td>
                        <td><input type="number" min="1" name="detalles[{{ $idx }}][cantidad]" class="form-control form-control-sm" value="{{ $d['cantidad'] ?? '' }}"></td>
                        <td><input type="text" name="detalles[{{ $idx }}][unidad]" class="form-control form-control-sm" value="{{ $d['unidad'] ?? '' }}"></td>
                        <td><input type="text" name="detalles[{{ $idx }}][descripcion]" class="form-control form-control-sm" value="{{ $d['descripcion'] ?? '' }}" required></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" title="Eliminar fila">
                            <i class="fas fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="text-right">
                <button type="button" id="btnAddItem" class="btn btn-outline-primary btn-sm">
                  <i class="fas fa-plus"></i> Agregar ítem
                </button>
              </div>

              @error('detalles') <small class="text-danger d-block">{{ $message }}</small> @enderror
              @error('detalles.*.descripcion') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>

            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
          </div>
        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">
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
  // Badge de notificaciones
  $(function () {
    $('#notificacionesDropdown').on('click', function () { $('#notiBadge').hide(); });
  });

  // DataTable Responsive con prioridades (sin filas con colspan)
  $(function () {
    $('#tablaRequerimientos').DataTable({
      responsive: {
        details: { type: 'inline', target: 'tr' }
      },
      autoWidth: false,
      columnDefs: [
        { responsivePriority: 1, targets: 0 },  // Código
        { responsivePriority: 2, targets: -1 }, // Acciones
        { responsivePriority: 3, targets: 1 },  // Fecha
        { responsivePriority: 4, targets: 2 },  // Área
        { responsivePriority: 5, targets: 3 },  // Solicitante
        { responsivePriority: 6, targets: 4 },  // Tipo
      ],
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        emptyTable: "No hay requerimientos registrados."
      }
    });
  });

  // Tabla dinámica de detalles (modal)
  $(function () {
    const $tbody = $('#tablaDetalles tbody');
    const $addBtn = $('#btnAddItem');
    let idx = $tbody.find('tr').length;

    function addRow(data = {}) {
      const html = `
        <tr>
          <td><input type="text" name="detalles[${idx}][identificacion]" class="form-control form-control-sm" value="${data.identificacion||''}"></td>
          <td><input type="number" min="1" name="detalles[${idx}][cantidad]" class="form-control form-control-sm" value="${data.cantidad||''}"></td>
          <td><input type="text" name="detalles[${idx}][unidad]" class="form-control form-control-sm" value="${data.unidad||''}"></td>
          <td><input type="text" name="detalles[${idx}][descripcion]" class="form-control form-control-sm" value="${data.descripcion||''}" required></td>
          <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm btn-del-row" title="Eliminar fila">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>`;
      $tbody.append(html);
      idx++;
    }

    $addBtn.on('click', () => addRow());

    $tbody.on('click', '.btn-del-row', function () {
      const $rows = $tbody.find('tr');
      if ($rows.length > 1) $(this).closest('tr').remove();
    });

    // Reabrir modal si hubo errores de validación (BS4/jQuery)
    @if ($errors->any())
      $('#modalAgregar').modal('show');
    @endif
  });
</script>

</body>
</html>
