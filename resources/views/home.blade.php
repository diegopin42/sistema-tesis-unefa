@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="p-5 mb-5 bg-white rounded-4 shadow-sm border-start border-5 border-primary">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 fw-bold text-dark">Bienvenido al sistema de gestión de Biblioteca</h1>
                <p class="fs-5 text-muted">Sistema de Control de Estudios y Gestión de Biblioteca <br> 
                   <span class="badge bg-unefa">UNEFA - Núcleo Caracas</span>
                </p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <img src="{{ asset('img/unefa-seeklogo.png') }}" alt="Logo" style="height: 150px; opacity: 0.8;">
            </div>
        </div>
    </div>

<div class="row g-4 text-center">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body py-5">
                <div class="icon-container mb-4">
                    <img src="{{ asset('img/tesis.png') }}" alt="Icono Tesis" class="home-icon">
                </div>
                <h4 class="fw-bold">Gestión de Tesis</h4>
                <p class="text-muted px-3">Administra archivos PDF, estados y fechas de presentación.</p>
                <a href="/tesis" class="btn btn-unefa rounded-pill px-4">Ingresar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body py-5">
                <div class="icon-container mb-4">
                    <img src="{{ asset('img/usuarios.png') }}" alt="Icono Usuarios" class="home-icon">
                </div>
                <h4 class="fw-bold">Autores y Tutores</h4>
                <p class="text-muted px-3">Registro y control de estudiantes y personal docente.</p>
                <a href="/personas" class="btn btn-unefa rounded-pill px-4">Gestionar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm hover-card">
            <div class="card-body py-5">
                <div class="icon-container mb-4">
                    <img src="{{ asset('img/config.png') }}" alt="Icono Config" class="home-icon">
                </div>
                <h4 class="fw-bold">Configuración</h4>
                <p class="text-muted px-3">Ajustes de Sedes, Carreras y Especializaciones.</p>
                <a href="{{ route('configuracion.index') }}" class="btn btn-unefa rounded-pill px-4">Configurar</a>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    /* Estilos para que los iconos se vean geniales */
    .icon-container {
        width: 100px;
        height: 100px;
        background-color: #e9ecef;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .home-icon {
        width: 55px;
        height: 55px;
        object-fit: contain;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        transition: transform 0.3s ease;
    }

    .hover-card:hover .icon-container {
        background-color: var(--dorado-unefa);
    }

    .btn-unefa {
        background-color: var(--azul-unefa);
        color: white;
        border: none;
    }

    .btn-unefa:hover {
        background-color: #002673;
        color: var(--dorado-unefa);
    }
</style>
@endsection