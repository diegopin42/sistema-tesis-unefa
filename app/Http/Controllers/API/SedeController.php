<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sede;
use App\Filters\SedeFilter;
use App\Http\Requests\APIStoreSedeRequest;
use App\Http\Requests\APIUpdateSedeRequest;
use App\Http\Resources\SedeResource;


class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new SedeFilter();
        $queryItems = $filter->transform($request);

        // Al listar sedes, incluimos sus carreras para el administrador
        $query = Sede::where($queryItems)->with('carreras');

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(APIStoreSedeRequest $request)
    {
        // Al usar APIStoreSedeRequest, los datos ya vienen validados aquí
        $sede = Sede::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Sede registrada correctamente',
            'data' => $sede
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
    public function update(APIUpdateSedeRequest $request, Sede $sede)
{
    $sede->update($request->validated());

    return response()->json([
        'status' => 'success',
        'message' => 'Sede actualizada con éxito',
        'data' => $sede
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Sede $sede)
{
    // Esto disparará el onDelete('cascade') que definiste en tus migraciones
    $sede->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Sede eliminada. Se han borrado las carreras y tesis asociadas.'
    ]);
}
}
