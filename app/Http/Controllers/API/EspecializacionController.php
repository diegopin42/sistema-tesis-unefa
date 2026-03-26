<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Especializacion;
use App\Filters\EspecializacionFilter;
use App\Http\Resources\EspecializacionResource;
use App\Http\Requests\APIStoreEspecializacionRequest;
use App\Http\Requests\APIUpdateEspecializacionRequest;

class EspecializacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $filter = new EspecializacionFilter();
    $queryItems = $filter->transform($request);

    // Cargamos la relación con carrera para mostrarla en la tabla
    $especializaciones = Especializacion::where($queryItems)->with('carrera')->get();

    return response()->json($especializaciones);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(APIStoreEspecializacionRequest $request)
    {
        $especializacion = Especializacion::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Especialización registrada correctamente',
            'data' => $especializacion->load('carrera.sede') // ¡Carga carrera y sede de un solo golpe!
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(APIUpdateEspecializacionRequest $request, Especializacion $especializacion)
    {
        $especializacion->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Especialización actualizada correctamente',
            'data' => $especializacion->load('carrera.sede')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Especializacion $especializacion)
    {
        // Al borrar la especialización, se borrarán las TESIS asociadas (cascade)
        $especializacion->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Especialización eliminada. Las tesis vinculadas también han sido removidas.'
        ]);
    }
}
