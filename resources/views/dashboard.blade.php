<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISTEMA INTEGRADO DE GESTION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar estilizado -->
  <nav class="main-header navbar navbar-expand" style="background-color: #003366; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <!-- Botón de menú lateral + logo -->
      <ul class="navbar-nav d-flex align-items-center gap-3">
        <li class="nav-item">
          <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars fa-lg"></i>
          </a>
        </li>
        <li>
           <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width: 25px; height: 25px; margin-right: 8px;">
        </li>
      </ul>


     <!-- Perfil de usuario -->
      
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 rounded-pill shadow-sm text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #002b5c;">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
              <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userDropdown" style="border-radius: 12px; min-width: 240px;">
              <li class="dropdown-item text-center bg-light py-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=64" alt="Avatar" class="rounded-circle mb-2">
                <strong class="text-dark">{{ Auth::user()->name }}</strong>
                <p class="text-muted small mb-0">Usuario activo</p>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2 px-3 py-2 text-danger" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt"></i> <span>Cerrar sesión</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>

  </div>
</nav>


<aside class="main-sidebar elevation-4" style="background-color: #1F1F1F;">

  <!-- Logo y título institucional -->
  <div class="brand-link d-flex align-items-center justify-content-center py-3" style="background-color: #121212; text-decoration: none;">
    <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width: 25px; height: 25px; margin-right: 8px;">
    <span class="brand-text fw-bold text-white" style="font-size: 1.2rem;">UNIENERGIA ABC</span>
  </div>

  <!-- Menú lateral -->
  <div class="sidebar">
    <nav class="mt-3">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <!-- Mantenimiento -->
        <li class="nav-item">
          <a href="{{ route('reportes.index') }}"
             class="nav-link text-white"
             style="transition: background-color 0.3s;"
             onmouseover="this.style.backgroundColor='#800000'" 
             onmouseout="this.style.backgroundColor='transparent'">
            <i class="nav-icon fas fa-tools text-success"></i>
            <p class="ms-2">Mantenimiento</p>
          </a>
        </li>

        <!-- Indicadores (activo simulado) -->
        <li class="nav-item">
          <a href="#" class="nav-link" style="background-color: #009933; color: white;">
            <i class="nav-icon fas fa-chart-bar text-white"></i>
            <p class="ms-2">Indicadores</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>

</aside>






<!-- Contenido principal -->
<div class="content-wrapper" style="background-color: #f8f9fa;">
  <div class="content-header py-3" style="border-bottom: 1px solid #dee2e6;">
    <div class="container-fluid">
      <h1 class="m-0 fw-semibold" style="font-family: 'Montserrat', sans-serif; color: #333;">
        Bienvenido, {{ Auth::user()->name }}
      </h1>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-left: 4px solid #28a745;">
          <i class="fas fa-check-circle me-2 text-success"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
    </div>
  </div>



        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <div class="flex-grow-1 text-center">
                <h3 class="card-title m-0 fw-semibold" style="color: #333; font-family: 'Montserrat', sans-serif;">
                  Registrar nuevo reporte.
                </h3>
              </div>
              <div class="ms-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalAgregar">
                  <i class="fas fa-plus me-1"></i> Agregar Registro
                </button>
              </div>
            </div>
          </div>
      </div>



     <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="px-3 w-100">
        <form action="{{ route('reportes.index') }}" method="GET" class="d-flex align-items-center" style="gap: 0.5rem;">
            <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}" style="max-width: 200px;">
            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}" style="max-width: 180px;">
            <button type="submit" class="btn btn-success d-flex align-items-center px-3">
                <i class="fas fa-search me-1"></i> Buscar
            </button>
        </form>
    </div>
</div>



    <!-- Reportes registrados arriba -->
<div class="card shadow-sm border-0">
  <div class="card-header bg-white border-bottom d-flex justify-content-center align-items-center">
  <h3 class="card-title mb-0 fw-semibold" style="color: #333; font-family: 'Montserrat', sans-serif;">
    📋 REPORTES DE MANTENIMIENTO MECANICO 
  </h3>
</div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="tablaReportes" class="table table-hover table-bordered align-middle text-center">
        <thead class="table-light">
          <tr class="text-muted">
            <th>Nombre</th>
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
              <td>{{ $reporte->fecha_inicio }}</td>
              <td>{{ $reporte->fecha_termino }}</td>
              <td>{{ $reporte->ubicacion }}</td>
              <td>{{ $reporte->tipo_equipo }}</td>
              <td>
                {{-- Ver Reporte --}}
                <a href="{{ route('reportes.show', $reporte->id) }}" 
                  class="btn btn-sm btn-outline-info shadow-sm fw-semibold me-1" 
                  title="Ver Reporte" target="_blank">
                  <i class="fas fa-eye me-1"></i> Ver
                </a>

                {{-- Editar --}}
                <button type="button" 
                        class="btn btn-sm btn-outline-warning shadow-sm fw-semibold me-1" 
                        data-bs-toggle="modal" data-bs-target="#editarModal{{ $reporte->id }}">
                  <i class="fas fa-edit me-1"></i> Editar
                </button>

                {{-- Eliminar --}}
                <form action="{{ route('reportes.destroy', $reporte->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('¿Estás seguro de eliminar este reporte?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" 
                          class="btn btn-sm btn-outline-danger shadow-sm fw-semibold" 
                          title="Eliminar">
                    <i class="fas fa-trash me-1"></i> Eliminar
                  </button>
                </form>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">No hay reportes registrados.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
      <div class="d-flex justify-content-end mt-4">
  <nav class="shadow-sm border rounded-pill bg-white px-3 py-1">
    <ul class="pagination pagination-sm mb-0">
      {{-- Flecha izquierda --}}
      @if ($reportes->onFirstPage())
        <li class="page-item disabled">
          <span class="page-link bg-transparent border-0 text-muted">
            <i class="fas fa-chevron-left"></i>
          </span>
        </li>
      @else
        <li class="page-item">
          <a class="page-link bg-transparent border-0 text-primary" href="{{ $reportes->previousPageUrl() }}">
            <i class="fas fa-chevron-left"></i>
          </a>
        </li>
      @endif

      {{-- Flecha derecha --}}
      @if ($reportes->hasMorePages())
        <li class="page-item">
          <a class="page-link bg-transparent border-0 text-primary" href="{{ $reportes->nextPageUrl() }}">
            <i class="fas fa-chevron-right"></i>
          </a>
        </li>
      @else
        <li class="page-item disabled">
          <span class="page-link bg-transparent border-0 text-muted">
            <i class="fas fa-chevron-right"></i>
          </span>
        </li>
      @endif
    </ul>
  </nav>
</div>

      <div class="px-3 py-2 text-end">
        <span class="text-muted">Total de reportes: <strong>{{ $reportes->count() }}</strong></span>
      </div>
       
    </div>
  </div>
</div>




@foreach($reportes as $reporte)
<div class="modal fade" id="editarModal{{ $reporte->id }}" tabindex="-1" aria-labelledby="editarLabel{{ $reporte->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form method="POST" action="{{ route('reportes.update', $reporte->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title fw-semibold" id="editarLabel{{ $reporte->id }}" style="color: #333;">
            ✏️ Editar Reporte de Mantenimiento
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control shadow-sm" value="{{ $reporte->nombre }}" required>
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
              <label for="tipo_equipo">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo" class="form-select shadow-sm" required>
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
              <input type="text" name="herramientas[]" class="form-control shadow-sm"
                value="{{ is_array($reporte->herramientas) ? implode(', ', $reporte->herramientas) : $reporte->herramientas }}">
            </div>

            <div class="col-md-6 mb-3">
              <label>Materiales <small>(separados por coma)</small></label>
              <input type="text" name="materiales[]" class="form-control shadow-sm"
                value="{{ is_array($reporte->materiales) ? implode(', ', $reporte->materiales) : $reporte->materiales }}">
            </div>

            <div class="col-md-12 mb-3">
              <label>Descripción de la actividad</label>
              <textarea name="descripcion_actividad" class="form-control shadow-sm" rows="3">{{ $reporte->descripcion_actividad }}</textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer justify-content-end bg-light">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Guardar cambios
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach









  <!-- Modal Agregar Registro -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form method="POST" action="{{ route('reportes.store') }}">
      @csrf
      <div class="modal-content shadow-sm border-0">
        <div class="modal-header bg-white border-bottom">
          <h5 class="modal-title fw-semibold" id="modalAgregarLabel" style="color: #333;">
            🛠️ Nuevo Reporte de Mantenimiento
          </h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control shadow-sm" 
                    value="{{ Auth::user()->name }}" readonly>
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
              <label for="tipo_equipo">Tipo de equipo</label>
              <select name="tipo_equipo" id="tipo_equipo" class="form-select shadow-sm" required>
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

        <div class="modal-footer justify-content-end bg-light">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>




  
</div>
   <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © 2025 <a href="#">Unienergia ABC</a>.</strong> Todos los derechos reservados.
  </footer>
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
 
</div>

  
</div>




<!-- Scripts -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- Bootstrap 5 JS y Popper.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>



<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




</body>
</html>


