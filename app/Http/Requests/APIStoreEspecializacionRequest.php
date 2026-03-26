<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIStoreEspecializacionRequest extends FormRequest
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
        'nombre'     => 'required|string|min:3|max:100',
        // Verificamos que la carrera_id sea válida
        'carrera_id' => 'required|integer|exists:carreras,id',
    ];
}

    public function messages(): array
{
    return [
        'carrera_id.exists' => 'La carrera seleccionada no existe. Debe crear la carrera primero.',
    ];
}
}
