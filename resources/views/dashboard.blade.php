<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISTEMA INTEGRADO DE GESTION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->


 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <div class="container-fluid">
    <!-- Botón de menú lateral -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <!-- Perfil de usuario alineado a la derecha -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle fa-lg me-2"></i>
          <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li class="dropdown-item text-center">
            <i class="fas fa-user-circle fa-2x mb-2"></i><br>
            <strong>{{ Auth::user()->name }}</strong>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt me-2"></i> Cerrar sesión
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>


  <!-- Sidebar -->


   <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="#" class="brand-link">
         <span class="brand-text font-weight-light; outline: none;">Sistema Integrado</span>
       </a>
      
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

        <li class="nav-item">
          <a href="{{ route('reportes.index') }}" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Mantenimiento</p>
          </a>
        </li>


      </ul>
    </nav>
  </div>
  
</aside>







  <!-- Contenido principal -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Bienvenido, {{ Auth::user()->name }}</h1>
        @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
      </div>
    </div>

  <div class="card card">
    <div class="card-header">
        <h3 class="card-title">Registrar nuevo reporte de mantenimiento</h3>
        <!-- Botón Agregar Registro -->
              <div class="text-right p-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
                  <i class="fas fa-plus"></i> Agregar Registro
                 </button>
    </div>            
  </div>

   <div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Formulario de búsqueda -->
    <form action="{{ route('reportes.index') }}" method="GET" class="d-flex">
        <input type="text" name="nombre" class="form-control me-2" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
        <input type="date" name="fecha" class="form-control me-2" value="{{ request('fecha') }}">
         <button type="submit" class="btn btn-primary d-flex align-items-center px-3">
           <i class="fas fa-search me-1"></i> Buscar
          </button>
    </form>
</div>


 <!-- Reportes registrados arriba -->

      <div class="card shadow-sm border-0">
  <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <h3 class="card-title mb-0">📋 Reportes registrados</h3>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table id="tablaReportes" class="table table-hover table-striped table-bordered text-center align-middle">
        <thead class="table-primary">
          <tr>
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
              <a href="{{ route('reportes.show', $reporte->id) }}" class="btn btn-sm btn-outline-info" title="Ver" target="_blank">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('reportes.edit', $reporte->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                <i class="fas fa-edit"></i>
              </a>
              <form action="{{ route('reportes.destroy', $reporte->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Estás seguro de eliminar este reporte?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                  <i class="fas fa-trash"></i>
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
        <div class="px-3 py-2 text-right">
           <span class="text-muted">Total de reportes: <strong>{{ $reportes->count() }}</strong></span>
        </div>
    </div>
  </div>
</div>





    <!-- Modal Agregar Registro -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form method="POST" action="{{ route('reportes.store') }}">
          @csrf
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-white" id="modalAgregarLabel">Nuevo Reporte de Mantenimiento</h5>
              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label>Nombre</label>
                  <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label>Fecha de inicio</label>
                  <input type="date" name="fecha_inicio" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label>Fecha de término</label>
                  <input type="date" name="fecha_termino" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="tipo_equipo" class="form-label">Tipo de equipo</label>
                  <select name="tipo_equipo" id="tipo_equipo" class="form-select" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Motor">Motor</option>
                    <option value="Unidad de Bombeo Mecánico">Unidad de Bombeo Mecánico</option>
                    <option value="Bomba de Transferencia">Bomba de Transferencia</option>
                    <option value="Caja Reductora">Caja Reductora</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label>Ubicación</label>
                  <input type="text" name="ubicacion" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Rotulado</label>
                  <input type="text" name="rotulado" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Herramientas <small>(separadas por coma)</small></label>
                  <input type="text" name="herramientas" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label>Materiales <small>(separados por coma)</small></label>
                  <input type="text" name="materiales" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                  <label>Descripción de la actividad</label>
                  <textarea name="descripcion_actividad" class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>


</div>
 
</div>


<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
   <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>Unienergia ABC © 2025 <a href="#">Unienergia ABC</a>.</strong> Todos los derechos reservados.
  </footer>
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


