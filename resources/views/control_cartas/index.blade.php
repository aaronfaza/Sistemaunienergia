<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Control y Seguimiento Cartas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

  <style>
    /* Correcciones de compatibilidad BS5 en AdminLTE */
    .nav-link { display: flex; align-items: center; }
    .input-group-text { border-radius: 12px 0 0 12px !important; }
    .form-control { border-radius: 0 12px 12px 0 !important; }
    /* Ajuste para que inputs sin grupo tengan borde redondeado completo */
    .form-control:not(.input-group > .form-control) { border-radius: 12px !important; }
    
    /* ===== Paleta corporativa ===== */
    :root{
      --brand-primary: #003366;
      --brand-primary-dark: #002B5C;
      --brand-accent: #00A86B;
      --brand-accent-dark: #038b5a;
      --brand-info: #17a2b8;
      --brand-danger: #dc3545;
      --sidebar-bg: #121212;
      --sidebar-main: #1F1F1F;
      --text-on-brand: #ffffff;
      --header-h: 56px;
      --footer-h: 44px;
    }

    /* Layout */
    html, body{ height: 100%; overflow: hidden; }
    .wrapper{ height: 100vh; overflow: hidden; display: flex; flex-direction: column; }

    /* Navbar */
    .navbar-uni { background-color: var(--brand-primary); box-shadow: 0 2px 4px rgba(0,0,0,.2); }
    .navbar-uni .nav-link, .navbar-uni .navbar-brand { color: var(--text-on-brand) !important; }
    .main-header{ z-index: 1035; height: var(--header-h); }

    /* Sidebar */
    .main-sidebar { background-color: var(--sidebar-main) !important; position: fixed; top: 0; bottom: 0; left: 0; height: 100vh; overflow-y: auto;}
    .brand-area { background-color: var(--sidebar-bg); padding: 10px; display: block; }
    .brand-area .brand-text { color: var(--text-on-brand); }
    .nav-sidebar .nav-link { color: #eaeaea !important; border-radius: .35rem; margin: 0 .25rem; }
    .nav-sidebar .nav-link.active {
      background: linear-gradient(90deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
      color: #fff !important;
    }

    /* Contenido */
    .content-wrapper{
      background-color:#f8f9fa;
      height: 100%;
      overflow: auto;
      padding-top: var(--header-h); /* Compensar navbar fixed si es necesario, o dejar que adminlte lo maneje */
    }

    /* Cards y Tablas */
    .card { border-radius: 18px; border: 1px solid rgba(0,0,0,.05); box-shadow: 0 14px 34px rgba(15,23,42,.06); margin-bottom: 20px;}
    .card-header { background: linear-gradient(180deg, #ffffff, #f9fafb); font-weight: 600; }
    
    .table thead th { background: #f8fafc !important; border: none; text-transform: uppercase; color: #475569; padding: .75rem; }
    .table tbody tr { background: #ffffff; box-shadow: 0 6px 18px rgba(15,23,42,.06); transition: transform .18s; }
    .table tbody tr:hover { transform: translateY(-1px); }
    .table tbody td { border: none; vertical-align: middle; padding: .65rem; }

    /* Botones */
    .btn { border-radius: 999px !important; font-weight: 600; }
    .btn-success { background: linear-gradient(135deg, #10b981, #047857); border: none; }
    .btn-primary { background: linear-gradient(135deg, #003366, #002B5C); border: none; }
    
    /* Estados */
    .estado-select { border-radius: 999px; font-weight: 600; font-size: 0.8rem; padding: 4px 10px; border: none; cursor: pointer; text-align: center; -webkit-appearance: none; appearance: none;}
    .estado-pendiente { background: rgba(245, 158, 11, .18); color: #b45309; }
    .estado-ejecutado { background: rgba(16, 185, 129, .20); color: #047857; }
    .estado-rechazado { background: rgba(239, 68, 68, .18); color: #b91c1c; }

    /* Modales */
    .modal-content { border-radius: 20px; border: none; }
    .modal-header { border-bottom: 1px solid rgba(0,0,0,.05); }
    .btn-close { filter: invert(1) grayscale(100%) brightness(200%); } /* X blanca en headers oscuros */
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-uni border-bottom-0">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-flex align-items-center ms-2">
          <img src="{{ asset('img/logo.png.png') }}" alt="Logo" style="width:25px;height:25px;">
        </li>
      </ul>

      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item dropdown me-3">
          <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell fa-lg text-white"></i>
            @if(isset($notificaciones) && $notificaciones->count() > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.6rem;">
                {{ $notificaciones->count() }}
              </span>
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="min-width:300px; max-height:400px; overflow-y:auto;">
            <h6 class="dropdown-header font-weight-bold text-dark">🔔 Últimos registros</h6>
            <div class="dropdown-divider"></div>
            </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-1 rounded-pill shadow-sm text-white"
             href="#" data-bs-toggle="dropdown" aria-expanded="false"
             style="background-color: var(--brand-primary-dark);">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
            <span class="d-none d-md-inline font-weight-semibold ms-2">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px;min-width:240px;">
             <li>
                <div class="dropdown-item text-center bg-light py-3">
                  <strong class="text-dark d-block">{{ Auth::user()->name }}</strong>
                </div>
             </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center px-3 py-2 text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt me-2"></i> <span>Cerrar sesión</span>
                </a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <aside class="main-sidebar elevation-4">
    <a href="#" class="brand-link text-center brand-area text-decoration-none">
      <img src="{{ asset('img/logo.png.png') }}" style="width:25px;height:25px;margin-right:8px;">
      <span class="brand-text font-weight-bold">UNIENERGIA ABC</span>
    </a>
    <div class="sidebar">
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <li class="nav-item">
             <a href="{{ route('bienvenida') }}" class="nav-link {{ request()->routeIs('bienvenida') ? 'active' : '' }}">
               <i class="nav-icon fas fa-home" style="color: var(--brand-secondary);"></i>
               <p class="ms-2 mb-0">Bienvenida</p>
             </a>
           </li>
           <li class="nav-item">
             <a href="{{ route('control_cartas.index') }}" class="nav-link {{ request()->routeIs('control_cartas.*') ? 'active' : '' }}">
                <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                <p class="ms-2 mb-0">Control Cartas</p>
             </a>
           </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper p-4">
    <div class="d-flex justify-content-between align-items-center mb-4 pt-3">
      <h1 class="m-0 font-weight-bold heading-font h3 text-dark">
        📋 CONTROL Y SEGUIMIENTO DE CARTAS
      </h1>
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        <i class="fas fa-plus me-1"></i> Agregar
      </button>
    </div>

    <section class="content">
      <div class="container-fluid px-0">
        <div class="card border-0">
          <div class="card-body">
            
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
              <h5 class="m-0">Listado de Cartas</h5>
              <form method="GET" action="{{ route('control_cartas.index') }}" class="d-flex">
                <div class="input-group">
                  <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar...">
                  <button type="submit" class="btn btn-primary" style="border-radius: 0 999px 999px 0 !important;">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>#</th>
                      <th>Código</th>
                      <th>Fecha</th>
                      <th>Servicio/Compra</th>
                      <th>Proveedor</th>
                      <th>Monto (S/)</th>
                      <th>Estado</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($cartas as $index => $carta)
                      <tr>
                        <td>{{ $cartas->firstItem() + $index }}</td>
                        <td class="fw-bold text-primary">{{ $carta->codigo }}</td>
                        <td>{{ \Carbon\Carbon::parse($carta->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $carta->servicio_compra }}</td>
                        <td>{{ $carta->proveedor_elegido }}</td>
                        <td>{{ $carta->monto_soles }}</td>
                        <td class="text-center">
                            <form action="{{ route('control_cartas.update_estado', $carta->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="estado" onchange="this.form.submit()" class="estado-select 
                                  @if($carta->estado === 'Pendiente') estado-pendiente 
                                  @elseif($carta->estado === 'Ejecutado') estado-ejecutado 
                                  @else estado-rechazado @endif">
                                    <option value="Pendiente" {{ $carta->estado == 'Pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                                    <option value="Ejecutado" {{ $carta->estado == 'Ejecutado' ? 'selected' : '' }}>🟢 Ejecutado</option>
                                    <option value="Rechazado" {{ $carta->estado == 'Rechazado' ? 'selected' : '' }}>🔴 Rechazado</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-center">
                          <div class="btn-group" role="group">
                              <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalVer{{ $carta->id }}"><i class="fas fa-eye"></i></button>
                              <button class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalEditar{{ $carta->id }}"><i class="fas fa-edit"></i></button>
                              
                              <form action="{{ route('control_cartas.destroy', $carta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                              </form>
                          </div>
                        </td>
                      </tr>

                      <div class="modal fade" id="modalEditar{{ $carta->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header bg-warning">
                              <h5 class="modal-title">Editar Carta — {{ $carta->codigo }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('control_cartas.update', $carta->id) }}" method="POST">
                              @csrf @method('PUT')
                              <div class="modal-body">
                                <div class="row g-3">
                                   <div class="col-md-3">
                                     <label class="form-label">Código</label>
                                     <input type="text" name="codigo" value="{{ $carta->codigo }}" class="form-control" required>
                                   </div>
                                   <div class="col-md-3">
                                     <label class="form-label">Fecha</label>
                                     <input type="date" name="fecha" value="{{ $carta->fecha }}" class="form-control" required>
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Servicio/Compra</label>
                                      <input type="text" name="servicio_compra" value="{{ $carta->servicio_compra }}" class="form-control">
                                   </div>
                                   </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    @empty
                      <tr><td colspan="8" class="text-center py-4">No hay cartas registradas</td></tr>
                    @endforelse
                  </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $cartas->links() }} 
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg">
      
      <div class="modal-header text-white" style="background:linear-gradient(135deg,#10b981,#047857);">
        <h5 class="modal-title fw-bold" id="modalAgregarLabel">
          <i class="fas fa-file-alt me-2"></i> Registro de Carta SO-PRO
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('control_cartas.store') }}" method="POST">
        @csrf
        <div class="modal-body bg-light">
          
          <div class="card mb-3 shadow-sm border-0">
            <div class="card-header bg-white text-success fw-bold">
               <i class="fas fa-info-circle me-1"></i> Datos generales
            </div>
            <div class="card-body">
              <div class="row g-3"> <div class="col-md-4">
                  <label class="form-label">Código</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-hashtag"></i></span>
                    <input type="text" class="form-control" name="codigo" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Fecha</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" class="form-control" name="fecha" required>
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Mes</label>
                  <input type="text" class="form-control" name="mes" placeholder="Ej: Marzo">
                </div>

              </div>
            </div>
          </div>

          <div class="card mb-3 shadow-sm border-0">
             <div class="card-header bg-white text-primary fw-bold">
               <i class="fas fa-briefcase me-1"></i> Detalle
            </div>
            <div class="card-body">
              <div class="row g-3">
                 <div class="col-md-6">
                    <label class="form-label">Servicio o Compra</label>
                    <input type="text" class="form-control" name="servicio_compra" required>
                 </div>
                 <div class="col-md-6">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="1"></textarea>
                 </div>
                 <div class="col-md-6">
                    <label class="form-label">Proveedor</label>
                    <div class="input-group">
                       <span class="input-group-text"><i class="fas fa-industry"></i></span>
                       <input type="text" class="form-control" name="proveedor_elegido">
                    </div>
                 </div>
                 <div class="col-md-3">
                    <label class="form-label">Monto (S/)</label>
                    <input type="number" step="0.01" class="form-control" name="monto_soles">
                 </div>
                 <div class="col-md-3">
                    <label class="form-label">Monto ($)</label>
                    <input type="number" step="0.01" class="form-control" name="monto_dolares">
                 </div>
              </div>
            </div>
          </div>

        </div> <div class="modal-footer bg-white">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success px-4">Guardar Registro</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>