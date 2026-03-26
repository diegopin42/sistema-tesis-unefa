<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Filters\CarreraFilter;
use App\Http\Requests\APIStoreCarreraRequest;
use App\Http\Resources\CarreraResource;
use App\Http\Requests\APIUpdateCarreraRequest;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CarreraFilter();
        $queryItems = $filter->transform($request);

        // Cargamos la relación con Sede para que el administrador 
        // sepa a qué sede pertenece cada carrera en el frontend.
        $query = Carrera::where($queryItems)->with('sede');

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(APIStoreCarreraRequest $request)
    {
        $carrera = Carrera::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Carrera registrada correctamente',
            'data' => $carrera->load('sede') // El load('sede') trae los datos de la sede también
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
    public function update(APIUpdateCarreraRequest $request, Carrera $carrera)
    {
        $carrera->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Carrera actualizada correctamente',
            'data' => $carrera->load('sede') // Cargamos la sede para confirmar el cambio
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carrera $carrera): JsonResponse
    {
        // Al borrar la carrera, se borrarán sus especializaciones y tesis (onDelete cascade)
        $carrera->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Carrera eliminada exitosamente junto con sus especializaciones'
        ]);
    }
}
