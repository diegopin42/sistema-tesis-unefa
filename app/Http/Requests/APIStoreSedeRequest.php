<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIStoreSedeRequest extends FormRequest
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
        // El nombre es obligatorio, debe ser único en la tabla 'sedes'
        'nombre' => 'required|string|unique:sedes,nombre|min:3|max:100',
    ];
}

    public function messages(): array
{
    return [
        'nombre.unique' => 'Ya existe una sede registrada con ese nombre.',
        'nombre.required' => 'El nombre de la sede es obligatorio.',
    ];
}
}
