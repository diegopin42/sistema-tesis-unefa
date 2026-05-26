<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Filters\SedeFilter;
use App\Models\Sede;
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

        $sedes = Sede::where($queryItems)
                ->with('carreras') 
                ->paginate()
                ->appends($request->query());
        
        return SedeResource::collection($sedes);
    
    }


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
