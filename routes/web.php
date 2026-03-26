<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfiguracionController;

// Importar todos los modelos necesarios
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\Especializacion;
use App\Models\Persona;
use App\Models\Tesis;

// --- Vistas Principales ---
Route::get('/', function () {
    return view('home');
})->name('home');

// --- Gestión de Tesis (Ruta Principal) ---
Route::get('/tesis', function () {
    // Eager loading para evitar lentitud
    $tesis = Tesis::with(['autor', 'tutor', 'especializacion.carrera.sede'])->latest()->get();
    
    // Datos para los selectores del modal
    $especializaciones = Especializacion::with('carrera')->get();
    $personas = Persona::all(); 

    return view('tesis.index', compact('tesis', 'especializaciones', 'personas'));
})->name('web.tesis.index');

// --- Gestión de Personas ---
Route::get('/personas', function () {
    $personas = Persona::all();
    return view('personas.index', compact('personas'));
})->name('web.personas.index');

// --- Grupo de Configuración ---
Route::prefix('configuracion')->group(function () {
    
    // Panel Principal (localhost:8000/configuracion)
    Route::get('/', [ConfiguracionController::class, 'index'])->name('configuracion.index');

    // Sedes
    Route::get('/sedes', function () {
        $sedes = Sede::with('carreras')->get();
        return view('configuracion.sedes.index', compact('sedes'));
    })->name('web.sedes.index');

    // Carreras
    Route::get('/carreras', function () {
        $carreras = Carrera::with('sede')->get();
        $sedes = Sede::all();
        return view('configuracion.carreras.index', compact('carreras', 'sedes'));
    })->name('web.carreras.index');

    // Especializaciones
    Route::get('/especializaciones', function () {
        $especializaciones = Especializacion::with('carrera.sede')->get();
        $carreras = Carrera::with('sede')->get();
        return view('configuracion.especializaciones.index', compact('especializaciones', 'carreras'));
    })->name('web.especializaciones.index');

});