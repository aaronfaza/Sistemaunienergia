<!-- resources/views/layouts/layout.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>SISTEMA INTEGRADO DE GESTION</title>
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
          <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Sistema Integrado</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Inicio</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Bienvenido, Aaron Joel</h1>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>UniEnergía © 2025 <a href="#">Unienergia ABC</a>.</strong> Todos los derechos reservados.
  </footer>
</div>

<!-- Scripts -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

</body>
</html>