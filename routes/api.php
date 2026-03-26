<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 1. Importa tus controladores (Asegúrate de agregar PersonaController)
use App\Http\Controllers\API\SedeController;
use App\Http\Controllers\API\CarreraController;
use App\Http\Controllers\API\TesisController;
use App\Http\Controllers\API\PersonaController; // <--- AGREGA ESTA LÍNEA
use App\Http\Controllers\API\EspecializacionController; // <--- AGREGA ESTA LÍNEA

Route::prefix('v1')->group(function () {

    Route::get('/status', function () {
        return response()->json(['message' => 'API de Tesis Operativa']);
    });

    // Rutas de Recurso
    Route::apiResource('sedes', SedeController::class);
    Route::apiResource('carreras', CarreraController::class);
    Route::apiResource('tesis', TesisController::class);
    Route::apiResource('personas', PersonaController::class); // <--- AGREGA ESTA LÍNEA
    Route::apiResource('especializaciones', EspecializacionController::class); // AGREGA ESTA LÍNEA

});