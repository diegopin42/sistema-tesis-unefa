<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class APIStoreEspecializacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|min:3|max:100',

            // Validamos que el tipo sea uno de los permitidos en el ENUM que hablamos
            'tipo' => ['required', Rule::in(['especializacion', 'maestria', 'doctorado', 'postdoctorado'])],

            // Verificamos que la carrera_id sea válida
            'carrera_id' => 'required|integer|exists:carreras,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del programa es obligatorio.',
            'tipo.required' => 'Debe especificar si es Especialización, Maestría o Doctorado.',
            'tipo.in' => 'El tipo de posgrado seleccionado no es válido.',
            'carrera_id.exists' => 'La carrera seleccionada no existe. Debe crear la carrera primero.',
        ];
    }
}