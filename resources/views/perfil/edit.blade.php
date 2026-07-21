<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Perfil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Icono -->
  <link rel="icon" href="{{ asset('img/logo.png.png') }}" type="image/png">

  <!-- AdminLTE 3 + Bootstrap 4 (coherentes) -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <style>
    :root{
      /* Paleta corporativa sobria — sin gradientes, sin tonos oscuros de fondo */
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

    .card-clean{ border-radius:4px; border:1px solid var(--border); box-shadow:none; }
    .card-clean .card-header{ background:var(--surface); font-weight:600; letter-spacing:.1px; border-bottom:1px solid var(--border); }

    .btn{ border-radius:3px!important; font-weight:600; font-size:.85rem; box-shadow:none!important; transition:background-color .12s ease; }
    .btn-brand{ background:var(--brand-primary); border:1px solid var(--brand-primary-dark); color:#fff!important; }
    .btn-brand:hover{ background:var(--brand-primary-dark); color:#fff; }
    .btn-fw{ font-weight:600; }

    .form-control, .custom-select{ border-radius:3px; font-size:.86rem; border-color:var(--border-strong); }
    .form-control:focus, .custom-select:focus{ border-color:var(--brand-primary); box-shadow:0 0 0 2px rgba(31,58,95,.12); }
    .form-control[readonly]{ background:var(--page-bg); color:var(--text-secondary); cursor:not-allowed; }
    label{ font-size:.82rem; font-weight:600; color:var(--text-primary); }

    /* ===== TARJETA DE PERFIL — plana, sin gradiente ===== */
    .profile-hero{
      background:var(--surface);
      border:1px solid var(--border);
      border-radius:4px;
      padding:1.5rem;
      position:relative;
    }
    .profile-photo-wrap{
      width:96px; height:96px;
      border-radius:50%;
      overflow:hidden;
      border:1px solid var(--border-strong);
      background:var(--page-bg);
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
    }
    .profile-photo-wrap img{ width:100%; height:100%; object-fit:cover; }
    .profile-photo-wrap i{ font-size:2.2rem; color:var(--text-secondary); }

    .rol-badge{
      display:inline-block;
      padding:.25rem .6rem;
      font-size:.72rem;
      font-weight:600;
      letter-spacing:.05em;
      text-transform:uppercase;
      border-radius:3px;
      background:var(--page-bg);
      border:1px solid var(--border);
      color:var(--brand-primary);
    }

    .info-readonly{
      background:var(--page-bg);
      border-radius:3px;
      padding:.9rem 1.1rem;
      border:1px solid var(--border);
    }
    .info-readonly label{
      display:block;
      font-size:.72rem;
      text-transform:uppercase;
      letter-spacing:.05em;
      color:var(--text-secondary);
      font-weight:700;
      margin-bottom:.2rem;
    }
    .info-readonly div{
      font-size:.95rem;
      font-weight:600;
      color:var(--text-primary);
    }

    .photo-input-btn{
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      background:var(--surface);
      border:1px solid var(--border-strong);
      color:var(--brand-primary);
      border-radius:3px;
      padding:.4rem .9rem;
      font-size:.82rem;
      font-weight:600;
      cursor:pointer;
      transition:background-color .12s ease;
    }
    .photo-input-btn:hover{ background:var(--page-bg); }
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
            @if($usuario->foto_perfil)
              <img src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Avatar" style="width:28px;height:28px;border-radius:2px;object-fit:cover;">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&background=1F3A5F&color=fff&size=28" alt="Avatar" style="width:28px;height:28px;border-radius:2px;">
            @endif
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ $usuario->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border" style="border-radius:4px;min-width:230px;">
            <div class="dropdown-item text-center bg-light py-3">
              @if($usuario->foto_perfil)
                <img src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Avatar" class="mb-2" style="width:56px;height:56px;border-radius:3px;object-fit:cover;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&background=1F3A5F&color=fff&size=56" alt="Avatar" class="mb-2" style="border-radius:3px;">
              @endif
              <strong class="text-dark d-block">{{ $usuario->name }}</strong>
              <p class="text-muted small mb-0">{{ $usuario->cargo ?? 'Cargo no asignado' }}</p>
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
          @if($usuario->foto_perfil)
            <img src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Avatar" class="avatar">
          @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&background=1F3A5F&color=fff&size=34" alt="Avatar" class="avatar">
          @endif
          <div class="text-truncate">
            <div class="nombre text-truncate">{{ $usuario->name }}</div>
            <div class="cargo text-truncate">{{ $usuario->cargo ?? 'Sin cargo asignado' }}</div>
          </div>
        </div>
        <a href="{{ route('logout') }}" class="sidebar-logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
          <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
      </div>
    </div>
  </aside>

  <!-- Contenido -->
  <div class="content-wrapper">
    <div class="content-header py-3 border-bottom bg-white">
      <div class="container-fluid">
        <h1 class="m-0" style="color:var(--text-primary);font-size:1.4rem;font-weight:700;">Mi Perfil</h1>
        <h5 class="mb-0" style="margin-top:2px;font-weight:400;font-size:.88rem;color:var(--text-secondary);">Tu información personal dentro del sistema</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius:4px;border-left:3px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="border-radius:4px;">
            <ul class="mb-0 pl-3">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
    </div>

    <div class="container-fluid pt-3">

      <form id="formPerfil" method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- ===== HERO: foto + datos básicos ===== -->
        <div class="profile-hero mb-4 d-flex flex-wrap align-items-center" style="gap:1.6rem;">
          <div class="profile-photo-wrap" id="previewWrap_perfil">
            @if($usuario->foto_perfil)
              <img id="previewImg_perfil" src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Foto de perfil">
            @else
              <i class="fas fa-user"></i>
              <img id="previewImg_perfil" src="" alt="Foto de perfil" style="display:none;">
            @endif
          </div>

          <div>
            <h3 class="mb-1" style="font-size:1.15rem;font-weight:700;color:var(--text-primary);">{{ $usuario->name }}</h3>
            <p class="mb-2" style="color:var(--text-secondary);">{{ $usuario->cargo ?? 'Cargo no asignado' }}</p>
            <span class="rol-badge">
              @if($usuario->esSupervisorMantenimiento()) Supervisor de Mantenimiento
              @elseif($usuario->esSoloMantenimiento()) Mecánico
              @elseif($usuario->esRRHH()) Recursos Humanos
              @elseif($usuario->esCuentaPendiente()) Pendiente de asignación
              @else Administración
              @endif
            </span>

            <div class="mt-3">
              <label for="foto_perfil_input" class="photo-input-btn mb-0">
                <i class="fas fa-camera"></i> Cambiar foto
              </label>
              <input type="file" id="foto_perfil_input" name="foto_perfil" accept="image/*" class="d-none">
            </div>
          </div>
        </div>

        <div class="row">
          <!-- ===== Datos editables ===== -->
          <div class="col-lg-6 mb-4">
            <div class="card card-clean h-100">
              <div class="card-header">
                <h3 class="card-title m-0" style="color:var(--text-primary);font-size:1rem;">
                  <i class="fas fa-edit mr-1" style="color:var(--brand-accent);"></i> Datos editables
                </h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label>Dirección</label>
                  <input type="text" name="direccion" class="form-control"
                         value="{{ old('direccion', $usuario->direccion) }}"
                         placeholder="Ej: Av. Principal 123, Piura">
                </div>

                <div class="mb-3">
                  <label>Fecha de cumpleaños</label>
                  <input type="date" name="fecha_nacimiento" class="form-control"
                         value="{{ old('fecha_nacimiento', optional($usuario->fecha_nacimiento)->format('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                  <label>Correo de recuperación</label>
                  <input type="email" name="correo_recuperacion" class="form-control"
                         value="{{ old('correo_recuperacion', $usuario->correo_recuperacion) }}"
                         placeholder="tuCorreoPersonal@gmail.com">
                  <small class="text-muted">Puede ser Gmail, Hotmail o cualquier correo personal. Aquí recibirás el código si olvidas tu contraseña.</small>
                </div>

                <button type="submit" class="btn btn-brand btn-fw">
                  <i class="fas fa-save mr-1"></i> Guardar cambios
                </button>
              </div>
            </div>
          </div>

          <!-- ===== Datos administrativos (solo lectura) ===== -->
          <div class="col-lg-6 mb-4">
            <div class="card card-clean h-100">
              <div class="card-header">
                <h3 class="card-title m-0" style="color:var(--text-primary);font-size:1rem;">
                  <i class="fas fa-id-badge mr-1" style="color:var(--brand-info);"></i> Datos administrativos
                </h3>
                <small class="text-muted">Estos datos los gestiona la administración del sistema.</small>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-6 mb-3">
                    <div class="info-readonly">
                      <label>Correo electrónico</label>
                      <div>{{ $usuario->email }}</div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <div class="info-readonly">
                      <label>Puesto</label>
                      <div>{{ $usuario->cargo ?? '—' }}</div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <div class="info-readonly">
                      <label>Edad</label>
                      <div>{{ $usuario->edad !== null ? $usuario->edad . ' años' : '—' }}</div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-3">
                    <div class="info-readonly">
                      <label>Fecha de ingreso a la empresa</label>
                      <div>{{ $usuario->fecha_ingreso ? $usuario->fecha_ingreso->format('d/m/Y') : '—' }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

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

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
  async function compressToJpeg(file, maxDim = 1920, quality = 0.82){
    let bitmap;
    try{ bitmap = await createImageBitmap(file); }catch(e){ return file; }
    const w = bitmap.width, h = bitmap.height;
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

  function replaceInputFile(input, file){
    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
  }

  async function prepararFotoParaEnvio(file, maxDim = 1920, quality = 0.82){
    const shouldCompress = (file.size > 1.5 * 1024 * 1024) || (file.type === 'image/png');
    if (shouldCompress) return await compressToJpeg(file, maxDim, quality);
    try {
      const buf = await file.arrayBuffer();
      return new File([buf], file.name || 'foto', { type: file.type, lastModified: Date.now() });
    } catch (e) {
      return file;
    }
  }

  let fotoPerfilProcessing = null;

  document.addEventListener('DOMContentLoaded', () => {
    const inputFoto = document.getElementById('foto_perfil_input');
    const form = document.getElementById('formPerfil');

    inputFoto.addEventListener('change', () => {
      const file = inputFoto.files && inputFoto.files[0];
      if(!file) return;

      if(!file.type.startsWith('image/')){
        inputFoto.value = '';
        alert('El archivo seleccionado no es una imagen válida.');
        return;
      }

      const wrap = document.getElementById('previewWrap_perfil');
      wrap.innerHTML = '';
      const img = document.createElement('img');
      img.id = 'previewImg_perfil';
      img.src = URL.createObjectURL(file);
      wrap.appendChild(img);

      fotoPerfilProcessing = (async () => {
        const optimized = await prepararFotoParaEnvio(file);
        if(optimized && optimized !== file){
          replaceInputFile(inputFoto, optimized);
          img.src = URL.createObjectURL(optimized);
        }
      })();
    });

    form.addEventListener('submit', async (e) => {
      if(fotoPerfilProcessing){
        e.preventDefault();
        try{ await fotoPerfilProcessing; }catch(err){}
        fotoPerfilProcessing = null;
        form.requestSubmit ? form.requestSubmit() : form.submit();
      }
    });
  });
</script>

</body>
</html>
