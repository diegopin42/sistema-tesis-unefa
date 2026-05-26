<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Procesar el formulario de la landing page.
     */
    public function submit(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre'  => 'required|string|max:255',
            'correo'  => 'required|email|max:255',
            'mensaje' => 'required|string',
        ]);

        // Aquí se puede guardar en una base de datos o enviar un correo
        // Por ahora lo simularemos enviando una respuesta JSON para Alpine.js de éxito.

        return response()->json([
            'success' => true,
            'message' => '¡Gracias! Hemos recibido tu solicitud correctamente.'
        ]);
    }
}
