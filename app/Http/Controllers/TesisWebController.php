<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tesis;
use App\Models\Persona;
use App\Models\Especializacion;
use App\Models\Sede;    // <--- Importado
use App\Models\Carrera; // <--- Importado
use Illuminate\Support\Facades\Storage;

class TesisWebController extends Controller
{
    public function index()
    {
        // 1. Cargamos las tesis con sus relaciones
        $tesis = Tesis::with(['autor', 'tutor', 'especializacion.carrera.sede'])->latest()->get();

        // 2. Cargamos los datos para los SELECT de los filtros Y para el modal antiguo
        $sedes = Sede::all();
        $carreras = Carrera::all();
        $especializaciones = Especializacion::all();
        $personas = Persona::all(); // <--- ESTA es la que faltaba para el modal

        // 3. Pasamos TODO a la vista
        return view('tesis.index', compact(
            'tesis',
            'sedes',
            'carreras',
            'especializaciones',
            'personas' // <--- Agrégala aquí también
        ));
    }

    public function create()
    {
        $personas = Persona::orderBy('nombre')->get();
        // Agrupamos por Carrera y Sede para el buscador interactivo
        $especializaciones = Especializacion::with('carrera.sede')->get();

        return view('tesis.create', compact('personas', 'especializaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:500',
            'autor_id' => 'required|exists:personas,id',
            'tutor_id' => 'required|exists:personas,id',
            'especializacion_id' => 'required|exists:especializaciones,id',
            'archivo' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        if ($request->hasFile('archivo')) {
            // Guardamos físicamente en storage/app/public/tesis
            $path = $request->file('archivo')->store('tesis', 'public');

            Tesis::create([
                'titulo' => $request->titulo,
                'autor_id' => $request->autor_id,
                'tutor_id' => $request->tutor_id,
                'especializacion_id' => $request->especializacion_id,
                'ruta_pdf' => $path,
            ]);

            return redirect()->route('web.tesis.index')->with('success', 'Tesis registrada exitosamente.');
        }

        return back()->withErrors(['archivo' => 'Error al subir el archivo.']);
    }
}