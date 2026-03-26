<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdateCarreraRequest extends FormRequest
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
        $carreraId = $this->route('carrera')->id;

        return [
            'nombre'  => "required|string|min:3|max:100|unique:carreras,nombre,{$carreraId}",
            'sede_id' => 'required|integer|exists:sedes,id',
        ];
    }

}
