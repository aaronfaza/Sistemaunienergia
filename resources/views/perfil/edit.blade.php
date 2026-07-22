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

  <!-- Fuente para títulos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap" rel="stylesheet">

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

    .card-clean{ border-radius:18px; border:1px solid rgba(0,0,0,.05); box-shadow:0 14px 34px rgba(15,23,42,.06); }
    .card-clean .card-header{ background:linear-gradient(180deg,#ffffff,#f9fafb); font-weight:600; letter-spacing:.2px; }

    .btn{ border-radius:999px!important; font-weight:600; letter-spacing:.2px; transition:all .2s ease; }
    .btn-brand{ background:linear-gradient(135deg,#2563eb,#1e40af); border:none; color:#fff!important; box-shadow:0 8px 20px rgba(37,99,235,.35); }
    .btn-brand:hover{ transform:translateY(-1px); box-shadow:0 14px 32px rgba(37,99,235,.45); }
    .btn-fw{ font-weight:600; }

    .form-control, .custom-select{ border-radius:12px; font-size:.9rem; transition:border-color .15s ease, box-shadow .15s ease; }
    .form-control:focus, .custom-select:focus{ border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.18); }
    .form-control[readonly]{ background:#f1f5f9; color:#64748b; cursor:not-allowed; }

    /* ===== TARJETA DE PERFIL ===== */
    .profile-hero{
      background:linear-gradient(120deg, var(--brand-primary) 0%, var(--brand-primary-dark) 60%, #001b3a 100%);
      border-radius:18px;
      padding:2rem;
      color:#fff;
      position:relative;
      overflow:hidden;
    }
    .profile-photo-wrap{
      width:120px; height:120px;
      border-radius:50%;
      overflow:hidden;
      border:4px solid rgba(255,255,255,.35);
      background:#0b1e3d;
      display:flex; align-items:center; justify-content:center;
      flex-shrink:0;
    }
    .profile-photo-wrap img{ width:100%; height:100%; object-fit:cover; }
    .profile-photo-wrap i{ font-size:2.6rem; color:rgba(255,255,255,.5); }

    .rol-badge{
      display:inline-block;
      padding:.25rem .7rem;
      font-size:.72rem;
      font-weight:700;
      letter-spacing:.05em;
      text-transform:uppercase;
      border-radius:999px;
      background:rgba(255,255,255,.16);
      color:#fff;
    }

    .info-readonly{
      background:#f8fafc;
      border-radius:12px;
      padding:.9rem 1.1rem;
      border:1px solid rgba(0,0,0,.05);
    }
    .info-readonly label{
      display:block;
      font-size:.72rem;
      text-transform:uppercase;
      letter-spacing:.05em;
      color:#94a3b8;
      font-weight:700;
      margin-bottom:.2rem;
    }
    .info-readonly div{
      font-size:.95rem;
      font-weight:600;
      color:#1e293b;
    }

    .photo-input-btn{
      display:inline-flex;
      align-items:center;
      gap:.4rem;
      background:rgba(255,255,255,.14);
      border:1px solid rgba(255,255,255,.3);
      color:#fff;
      border-radius:999px;
      padding:.4rem .9rem;
      font-size:.82rem;
      cursor:pointer;
      transition:background .2s ease;
    }
    .photo-input-btn:hover{ background:rgba(255,255,255,.24); }
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center px-3 py-2 rounded-pill shadow-sm text-white"
             href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false"
             style="background-color: var(--brand-primary-dark);">
            @if($usuario->foto_perfil)
              <img src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Avatar" class="rounded-circle" width="32" height="32" style="object-fit:cover;">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&background=003366&color=fff&size=32" alt="Avatar" class="rounded-circle" width="32" height="32">
            @endif
            <span class="d-none d-md-inline font-weight-semibold ml-2">{{ $usuario->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius:12px;min-width:240px;">
            <div class="dropdown-item text-center bg-light py-3">
              @if($usuario->foto_perfil)
                <img src="{{ asset('storage/'.$usuario->foto_perfil) }}" alt="Avatar" class="rounded-circle mb-2" style="width:64px;height:64px;object-fit:cover;">
              @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&background=003366&color=fff&size=64" alt="Avatar" class="rounded-circle mb-2">
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

        @unless(Auth::user()->esLogistica())
        @if(Auth::user()->puedeGestionarBoletas())
        <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users" style="color: var(--brand-accent);"></i>
            <p>
              RRHH
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview ml-2">
            <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                <p>
                  2026
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('boletas.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar nav-icon" style="color: var(--brand-accent);"></i>
                    <p>Boletas 2026</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                <p>
                  2027
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('boletas.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('boletas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar nav-icon" style="color: var(--brand-accent);"></i>
                    <p>Boletas 2027</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item">
          <a href="{{ route('boletas.index') }}" class="nav-link {{ request()->routeIs('boletas.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice-dollar" style="color: var(--brand-accent);"></i>
            <p class="ml-2 mb-0">Mis Boletas</p>
          </a>
        </li>
        @endif
        @endunless

          @if(Auth::user()->tieneAccesoCompleto())
          <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase" style="color: var(--brand-info);"></i>
              <p>
                Administración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ml-2">
              <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                  <p>
                    2026
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('requerimientos.index', ['anio' => 2026]) }}"
                      class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                      <i class="fas fa-file-alt nav-icon" style="color: var(--brand-info);"></i>
                      <p>Requerimientos</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                  <p>
                    2027
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('requerimientos.index', ['anio' => 2027]) }}"
                      class="nav-link {{ request()->routeIs('requerimientos.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                      <i class="fas fa-file-alt nav-icon" style="color: var(--brand-info);"></i>
                      <p>Requerimientos</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

        <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') ? 'menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-folder-open" style="color: var(--brand-info);"></i>
            <p>
              Control Cartas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview ml-2">
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                <p>
                  2026
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('control_cartas.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('control_cartas.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                    <p>SO-PRO</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_fis.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_fis.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                    <p>FIS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_ipf.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_ipf.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-drafting-compass nav-icon" style="color: var(--brand-accent);"></i>
                    <p>IPF</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_man.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                    <p>MAN</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_log.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_log.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-warehouse nav-icon" style="color: var(--brand-accent);"></i>
                    <p>LOG</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_hse.index', ['anio' => 2026]) }}"
                    class="nav-link {{ request()->routeIs('cartas_hse.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                    <i class="fas fa-hard-hat nav-icon" style="color: var(--brand-info);"></i>
                    <p>HSE</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ request()->routeIs('control_cartas.*', 'cartas_fis.*', 'cartas_ipf.*', 'cartas_man.*', 'cartas_log.*', 'cartas_hse.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                <p>
                  2027
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                  <a href="{{ route('control_cartas.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('control_cartas.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="far fa-envelope nav-icon" style="color: var(--brand-accent);"></i>
                    <p>SO-PRO</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_fis.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_fis.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="far fa-clipboard nav-icon" style="color: var(--brand-info);"></i>
                    <p>FIS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_ipf.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_ipf.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-drafting-compass nav-icon" style="color: var(--brand-accent);"></i>
                    <p>IPF</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_man.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                    <p>MAN</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_log.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_log.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-warehouse nav-icon" style="color: var(--brand-accent);"></i>
                    <p>LOG</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('cartas_hse.index', ['anio' => 2027]) }}"
                    class="nav-link {{ request()->routeIs('cartas_hse.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                    <i class="fas fa-hard-hat nav-icon" style="color: var(--brand-info);"></i>
                    <p>HSE</p>
                  </a>
                </li>
              </ul>
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
          @elseif(Auth::user()->puedeVerCartasMan())
          <li class="nav-item has-treeview {{ request()->routeIs('cartas_man.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('cartas_man.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-folder-open" style="color: var(--brand-info);"></i>
              <p>
                Control Cartas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ml-2">
              <li class="nav-item has-treeview {{ request()->routeIs('cartas_man.*') && request()->query('anio', '2026') === '2026' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-accent);"></i>
                  <p>
                    2026
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('cartas_man.index', ['anio' => 2026]) }}"
                      class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio', '2026') === '2026' ? 'active' : '' }}">
                      <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                      <p>MAN</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item has-treeview {{ request()->routeIs('cartas_man.*') && request()->query('anio') === '2027' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-calendar-alt" style="color: var(--brand-secondary);"></i>
                  <p>
                    2027
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview ml-2">
                  <li class="nav-item">
                    <a href="{{ route('cartas_man.index', ['anio' => 2027]) }}"
                      class="nav-link {{ request()->routeIs('cartas_man.*') && request()->query('anio') === '2027' ? 'active' : '' }}">
                      <i class="fas fa-wrench nav-icon" style="color: var(--brand-info);"></i>
                      <p>MAN</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          @endif

          @if(Auth::user()->esLogistica())
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
        <h1 class="m-0 heading-font" style="color:#333;">Mi Perfil</h1>
        <h5 class="text-muted" style="margin-top:4px;">Tu información personal dentro del sistema</h5>

        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert" style="border-left:4px solid var(--brand-accent);">
            <i class="fas fa-check-circle mr-2" style="color: var(--brand-accent);"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm" role="alert">
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

    <div class="container-fluid">

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
            <h3 class="mb-1 heading-font">{{ $usuario->name }}</h3>
            <p class="mb-2" style="opacity:.85;">{{ $usuario->cargo ?? 'Cargo no asignado' }}</p>
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
              <div class="card-header bg-white border-bottom">
                <h3 class="card-title m-0 heading-font" style="color:#333;">
                  <i class="fas fa-edit mr-1" style="color:var(--brand-accent);"></i> Datos editables
                </h3>
              </div>
              <div class="card-body">
                <div class="mb-3">
                  <label>Dirección</label>
                  <input type="text" name="direccion" class="form-control shadow-sm"
                         value="{{ old('direccion', $usuario->direccion) }}"
                         placeholder="Ej: Av. Principal 123, Piura">
                </div>

                <div class="mb-3">
                  <label>Fecha de cumpleaños</label>
                  <input type="date" name="fecha_nacimiento" class="form-control shadow-sm"
                         value="{{ old('fecha_nacimiento', optional($usuario->fecha_nacimiento)->format('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                  <label>Correo de recuperación</label>
                  <input type="email" name="correo_recuperacion" class="form-control shadow-sm"
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
              <div class="card-header bg-white border-bottom">
                <h3 class="card-title m-0 heading-font" style="color:#333;">
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
