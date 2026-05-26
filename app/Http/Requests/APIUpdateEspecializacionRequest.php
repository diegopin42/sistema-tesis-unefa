<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class APIUpdateEspecializacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Laravel permite obtener el ID directamente del parámetro de la ruta así:
        $especializacionId = $this->route('especializacione');
        $id = is_object($especializacionId) ? $especializacionId->id : $especializacionId;

        return [
            // Validamos que el nombre sea único, pero ignoramos el registro actual ($id)
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('especializaciones', 'nombre')->ignore($id)
            ],

            // Añadimos la validación del tipo para posgrados
            'tipo' => [
                'required',
                Rule::in(['especializacion', 'maestria', 'doctorado', 'postdoctorado'])
            ],

            'carrera_id' => 'required|exists:carreras,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe un programa con este nombre en el sistema.',
            'tipo.in' => 'El tipo de posgrado seleccionado no es válido.',
            'carrera_id.exists' => 'La carrera seleccionada no es válida.',
        ];
    }
}