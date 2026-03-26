<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdatePersonaRequest extends FormRequest
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
    // Obtenemos el ID de la ruta de forma más robusta
    $persona = $this->route('persona');
    $personaId = is_object($persona) ? $persona->id : $persona;

    return [
        'nombre'    => 'required|string|min:2|max:100',
        'apellidos' => 'required|string|min:2|max:100',
        // Esto permite que la cédula sea la misma si no se cambió, 
        // pero valida que no sea la de alguien más.
        'cedula'    => "required|string|max:20|unique:personas,cedula,{$personaId}",
        'rol'       => 'required|in:estudiante,tutor,jurado,administrador',
    ];
}

    public function messages(): array
    {
        return [
            'cedula.unique' => 'Esta cédula ya pertenece a otro usuario registrado.',
            'rol.in'        => 'El rol seleccionado no es válido para el sistema.',
        ];
    }
}
