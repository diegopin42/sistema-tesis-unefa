<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\EspecializacionFilter;
use App\Models\Especializacion;
use App\Http\Resources\EspecializacionResource;


class EspecializacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $filter = new EspecializacionFilter();
    $queryItems = $filter->transform($request);

    $especializaciones = Especializacion::where($queryItems)
                        ->with('carrera')
                        ->paginate()
                        ->appends($request->query());

    return response()->json($especializaciones);    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
