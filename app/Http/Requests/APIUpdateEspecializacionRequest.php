<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdateEspecializacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 1. Obtenemos el parámetro de la ruta. 
        // Para 'especializaciones', Laravel usa 'especializacione' por defecto.
        $parametro = $this->route('especializacione'); 

        // 2. Nos aseguramos de tener el ID, ya sea que recibamos el objeto o solo el número
        $id = is_object($parametro) ? $parametro->id : $parametro;

        return [
            // 3. Usamos la variable $id corregida aquí
            'nombre' => 'required|string|max:255|unique:especializaciones,nombre,' . $id,
            'carrera_id' => 'required|exists:carreras,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Esta especialización ya existe en el sistema.',
            'carrera_id.exists' => 'La carrera seleccionada no es válida.',
        ];
    }
}