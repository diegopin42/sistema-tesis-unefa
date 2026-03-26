<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdateSedeRequest extends FormRequest
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
        // El 'unique' ignora el ID actual para que no de error si no cambias el nombre
        $sedeId = $this->route('sede')->id;

        return [
            'nombre' => "required|string|min:3|max:100|unique:sedes,nombre,{$sedeId}",
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe otra sede con ese nombre en el sistema.',
        ];
    }
}
