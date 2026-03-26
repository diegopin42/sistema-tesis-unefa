<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdateTesisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array{
        return [
'titulo'             => 'sometimes|required|string|max:255',
'especializacion_id' => 'sometimes|required|exists:especializaciones,id',
            'autor_id'           => 'required|exists:personas,id',
            'tutor_id'           => 'required|exists:personas,id',
            'estado'             => 'required|in:recibida,en_revision,aprobada,rechazada',
            'fecha_presentacion' => 'nullable|date',
            // El archivo es opcional en la actualización
            'ruta_pdf'           => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
