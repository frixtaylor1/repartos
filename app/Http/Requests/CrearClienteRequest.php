<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearClienteRequest extends FormRequest
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
            'codigo'       => 'required|string',
            'razon_social' => 'required|string',
            'direccion'    => 'required|string',
            'latitud'      => 'nullable|numeric',
            'longitud'     => 'nullable|numeric',
            'email'        => 'required|email|unique:clientes,email',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required'        => 'El código es obligatorio.',
            'razon_social.required'  => 'La razón social es obligatoria.',
            'direccion.required'     => 'La dirección es obligatoria.',
            'latitud.numeric'        => 'La latitud debe ser un número.',
            'longitud.numeric'       => 'La longitud debe ser un número.',
            'email.required'         => 'El email es obligatorio.',
            'email.email'            => 'El email debe ser válido.',
            'email.unique'           => 'El email ya está registrado.',
        ];
    }
}
