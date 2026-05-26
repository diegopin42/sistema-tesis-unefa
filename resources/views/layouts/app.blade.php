<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tesis - UNEFA</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/unefa-seeklogo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Alpine.js via Vite -->
    @vite('resources/js/app.js')
    <style>
        :root {
            --azul-unefa: #003399;
            --dorado-unefa: #ffcc00;
            --blanco: #ffffff;
            --fondo-gris: #f8f9fa;
        }

        body { 
            padding-top: 95px; 
            background-color: var(--fondo-gris);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .navbar-unefa {
            background-color: var(--azul-unefa) !important;
            border-bottom: 4px solid var(--dorado-unefa);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .offcanvas-unefa {
            background-color: var(--azul-unefa) !important;
            color: var(--blanco) !important;
            border-left: 3px solid var(--dorado-unefa);
        }

        .offcanvas-title {
            color: var(--dorado-unefa);
            font-weight: bold;
        }

        .offcanvas-unefa .nav-link {
            color: var(--blanco) !important;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .offcanvas-unefa .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: var(--dorado-unefa) !important;
        }

        .menu-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark fixed-top navbar-unefa">
  <div class="container-fluid px-md-5">
    
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="{{ asset('img/unefa-seeklogo.png') }}" alt="Logo" style="height: 55px; width: auto;" class="me-3">
      <div class="d-flex flex-column lh-1">
        <span class="fs-2 fw-bolder text-white">UNEFA</span>
        <small class="text-uppercase fw-bold" style="font-size: 0.65rem; color: var(--dorado-unefa);">
            Excelencia Educativa Abierta al Pueblo
        </small>
      </div>
    </a>

    <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="offcanvas offcanvas-end offcanvas-unefa" tabindex="-1" id="offcanvasMenu">
      <div class="offcanvas-header border-bottom border-light">
        <h5 class="offcanvas-title">PANEL DE CONTROL</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>
      
      <div class="offcanvas-body p-0 d-flex flex-column">
        <ul class="navbar-nav flex-grow-1">
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="/">
              <span class="me-3 fs-5">🏠</span> Inicio 
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="/tesis">
              <img src="{{ asset('img/tesis.png') }}" class="menu-icon me-3" alt="Tesis">
              Gestión de Tesis
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="/personas">
              <img src="{{ asset('img/usuarios.png') }}" class="menu-icon me-3" alt="Personas">
              Autores y Tutores
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="{{ route('web.solicitudes.index') }}">
              <span class="me-3 fs-5">📥</span>
              Bandeja de Landing
              <!-- Alpine badge indicando notificaciones (Opcional visual) -->
            </a>
          </li>
          
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
        <img src="{{ asset('img/config.png') }}" class="menu-icon me-3" alt="Config">
        Configuración
    </a>
<ul class="dropdown-menu dropdown-menu-dark shadow border-light" style="background-color: var(--azul-unefa);">
    <li><a class="dropdown-item py-2" href="{{ route('web.sedes.index') }}">🏢 Sedes</a></li>
    <li><a class="dropdown-item py-2" href="{{ route('web.carreras.index') }}">🎓 Carreras</a></li>
    <li><a class="dropdown-item py-2" href="{{ route('web.especializaciones.index') }}">📜 Especializaciones</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item py-2 fw-bold text-warning" href="{{ route('configuracion.index') }}">⚙️ Panel General</a></li>
</ul>
</li>
        </ul>

        <div class="p-4 text-center border-top border-secondary">
            <img src="{{ asset('img/unefa-seeklogo.png') }}" width="50" class="mb-2 opacity-75">
            <p class="mb-0 text-white-50 small">UNEFA - Núcleo Caracas<br>Sistemas v1.0</p>
        </div>
      </div>
    </div>
  </div>
</nav>

<main class="container-fluid py-4 px-md-5">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>