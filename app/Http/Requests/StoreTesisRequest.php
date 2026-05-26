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
        'titulo' => 'required|string|max:500',
        'resumen' => 'required|string',
        'anio' => 'required|integer|min:2000|max:' . date('Y'),
        'carrera_id' => 'required|exists:carreras,id',
        'tutor_id' => 'required|exists:personas,id',
        // Validamos que 'autores' sea un array y que cada ID exista en la tabla personas
        'autores' => 'required|array|min:1',
        'autores.*' => 'exists:personas,id',
        // Validación del archivo PDF
        'pdf_archivo' => 'required|file|mimes:pdf|max:10240', // Máximo 10MB
    ];
    }
}
