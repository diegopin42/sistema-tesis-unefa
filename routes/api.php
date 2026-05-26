<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SedeController;
use App\Http\Controllers\API\CarreraController;
use App\Http\Controllers\API\EspecializacionController;
use App\Http\Controllers\API\PersonaController;
use App\Http\Controllers\API\TesisController;

// Ruta de usuario (Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Grupo de la API v1
Route::prefix('v1')->group(function () {
    Route::apiResource('sedes', SedeController::class);
    Route::apiResource('carreras', CarreraController::class);
    Route::apiResource('especializaciones', EspecializacionController::class);
    Route::apiResource('personas', PersonaController::class);
    Route::apiResource('tesis', TesisController::class);
});