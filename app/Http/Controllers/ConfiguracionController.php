<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// IMPORTANTE: Aquí le das la ubicación de tus modelos
use App\Models\Sede;
use App\Models\Carrera;
use App\Models\Especializacion; 

class ConfiguracionController extends Controller
{
    public function index() 
    {
        // Ahora sí podrá contar los registros de la base de datos
        return view('configuracion.index', [
            'totalSedes' => Sede::count(),
            'totalCarreras' => Carrera::count(),
            'totalEspecializaciones' => Especializacion::count(),
        ]);
    }
}