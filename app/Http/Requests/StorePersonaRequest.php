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
        'nombre' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'cedula' => 'required|string|unique:personas,cedula|max:20', // Clave: única en la tabla
        'rol' => 'required|in:autor,tutor,ambos',
    ];
    }
}
