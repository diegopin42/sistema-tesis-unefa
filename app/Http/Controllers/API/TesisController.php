<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tesis;
use App\Filters\TesisFilter;
use App\Http\Requests\StoreTesisRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\APIUpdateTesisRequest;

class TesisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new TesisFilter();
        $queryItems = $filter->transform($request); // Transforma la URL en arreglos de Eloquent

        // Aplicamos los filtros y cargamos relaciones
        $tesis = Tesis::where($queryItems)->with(['autor', 'tutor', 'especializacion.carrera.sede']);

        return response()->json($tesis->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTesisRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('ruta_pdf')) {
        // Guarda el PDF en storage/app/public/tesis
        $path = $request->file('ruta_pdf')->store('tesis', 'public');
        $data['ruta_pdf'] = $path;
    }

    $tesis = Tesis::create($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Tesis registrada y archivo subido con éxito',
        'data' => $tesis->load(['autor', 'tutor', 'especializacion.carrera.sede'])
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
    public function update(APIUpdateTesisRequest $request, Tesis $tesis)
    {
        $data = $request->validated();

        if ($request->hasFile('ruta_pdf')) {
            // 1. Borrar el archivo anterior del storage
            if ($tesis->ruta_pdf) {
                Storage::disk('public')->delete($tesis->ruta_pdf);
            }
            // 2. Guardar el nuevo archivo
            $data['ruta_pdf'] = $request->file('ruta_pdf')->store('tesis', 'public');
        }

        $tesis->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Tesis actualizada correctamente',
            'data' => $tesis->load(['autor', 'tutor', 'especializacion.carrera.sede'])
        ]);
    }

    public function destroy(Tesis $tesis)
    {
        // Borrar el archivo físico antes de eliminar el registro
        if ($tesis->ruta_pdf) {
            Storage::disk('public')->delete($tesis->ruta_pdf);
        }

        $tesis->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Tesis y archivo eliminados permanentemente'
        ]);
    }
}
