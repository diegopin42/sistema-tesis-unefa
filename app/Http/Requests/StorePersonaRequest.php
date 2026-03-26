<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
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
        'nombre'    => 'required|string|min:2|max:50',
        'apellidos' => 'required|string|min:2|max:50',
        // La cédula debe ser única en la tabla 'personas'
        'cedula'    => 'required|string|unique:personas,cedula|max:15',
        // Validamos que el rol sea uno de los permitidos
        // En StorePersonaRequest.php
'rol' => 'required|in:estudiante,tutor,jurado,administrador',
    ];
    }

    public function messages(): array
{
    return [
        'cedula.unique' => 'Esta cédula ya se encuentra registrada en el sistema.',
        'rol.in'        => 'El rol seleccionado no es válido.',
    ];
}
}

