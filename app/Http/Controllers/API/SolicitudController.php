<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Retornar todas las solicitudes (usado por el cliente/dashboard)
     */
    public function index()
    {
        // Traer las solicitudes más recientes primero
        $solicitudes = Solicitud::latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $solicitudes
        ]);
    }

    /**
     * Guardar una nueva solicitud desde la Landing Page.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre'  => 'required|string|max:255',
            'correo'  => 'required|email|max:255',
            'mensaje' => 'required|string',
        ]);

        // Guardamos en Base de datos
        $solicitud = Solicitud::create($validated);

        return response()->json([
            'success' => true,
            'message' => '¡Gracias! Hemos recibido tu solicitud correctamente y está en revisión.',
            'data'    => $solicitud
        ], 201);
    }

    /**
     * Marcar como leída/revisada (opcional para el dashboard)
     */
    public function markAsRead(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->estado = 'revisado';
        $solicitud->save();

        return response()->json([
            'success' => true,
            'message' => 'Solicitud marcada como revisada.'
        ]);
    }
}
