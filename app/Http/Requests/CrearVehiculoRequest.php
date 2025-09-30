<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearVehiculoRequest extends FormRequest
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
            'patente' => 'required|string|unique:vehiculos,patente',
            'modelo'  => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'patente.required' => 'La patente es obligatoria.',
            'patente.unique'   => 'La patente ya está registrada.',
            'modelo.required'  => 'El modelo es obligatorio.',
        ];
    }
}
