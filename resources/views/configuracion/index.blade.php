@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-gear-fill"></i> Panel de Configuración</h2>
    <hr>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Sedes</h5>
                    <p class="display-6">{{ $totalSedes }}</p>
                    <a href="{{ route('web.sedes.index') }}" class="btn btn-primary w-100">
    Administrar Sedes
</a><TY></TY>
<Y></Y>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Carreras</h5>
                    <p class="display-6">{{ $totalCarreras }}</p>
                    <a href="{{ route('web.carreras.index') }}" class="btn btn-success w-100">
                        Administrar Carreras
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Especializaciones</h5>
                    <p class="display-6">{{ $totalEspecializaciones }}</p>
<a href="{{ route('web.especializaciones.index') }}" class="btn btn-info text-white w-100">                        Administrar Especializaciones
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection