<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTesisRequest extends FormRequest
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
    public function rules(): array
    {
    return [
        'titulo'             => 'required|string|max:255',
        'especializacion_id' => 'required|exists:especializaciones,id',
        'autor_id'           => 'required|exists:personas,id',
        'tutor_id'           => 'required|exists:personas,id',
        'estado' => 'required|in:recibida,en_revision,aprobada,rechazada',       
        'fecha_presentacion' => 'nullable|date',
        // Validación del archivo PDF
    'ruta_pdf' => [
    'required',
    'file',
    'mimes:pdf,doc,docx', // Agregamos los formatos de Word
    'max:10240'           // Mantenemos el límite de 10MB
],    ];
    }
}
