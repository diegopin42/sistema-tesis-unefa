<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonaRequest;
use App\Models\Persona;
use App\Filters\PersonaFilter;
use App\Http\Resources\PersonaResource;
use App\Http\Requests\APIUpdatePersonaRequest;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // 1. Instanciamos tu filtro
    $filter = new PersonaFilter();
    
    // 2. Transformamos los parámetros de la URL en condiciones de Eloquent
    // (Asumiendo que tu clase ApiFilter tiene el método transform)
    $queryItems = $filter->transform($request); 

    // 3. Consultamos la base de datos
    if (count($queryItems) == 0) {
        // Si no hay filtros, traemos todo
        $personas = Persona::all();
    } else {
        // Si hay filtros, aplicamos el WHERE
        $personas = Persona::where($queryItems)->get();
    }

    return response()->json([
        'status' => 'success',
        'data'   => $personas
    ], 200);
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(StorePersonaRequest $request)
    {
    // Solo entramos aquí si los datos son correctos
    $persona = Persona::create($request->validated());

    return response()->json([
        'status'  => 'success',
        'message' => 'Persona registrada correctamente',
        'data'    => $persona
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        return response()->json([
        'status' => 'success',
        'data' => $persona
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(APIUpdatePersonaRequest $request, Persona $persona)
    {
        $persona->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Datos de la persona actualizados correctamente',
            'data' => $persona
        ]);
    }

    public function destroy(Persona $persona)
    {
        try {
            $persona->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Persona eliminada del sistema'
            ]);
        } catch (\Exception $e) {
            // Este error saltará si la persona es autor o tutor de una tesis existente
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar la persona porque tiene registros vinculados (tesis/tutorías).'
            ], 400);
        }
    }
}
