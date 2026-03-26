<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIStoreCarreraRequest extends FormRequest
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
        'nombre'  => 'required|string|min:3|max:100',
        // 'exists' verifica que el ID enviado esté en la columna 'id' de la tabla 'sedes'
        'sede_id' => 'required|integer|exists:sedes,id',
    ];
}

    public function messages(): array
{
    return [
        'sede_id.exists' => 'La sede seleccionada no es válida o no existe en el sistema.',
    ];
}
}
