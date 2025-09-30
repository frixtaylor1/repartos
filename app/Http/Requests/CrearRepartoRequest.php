<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearRepartoRequest extends FormRequest
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
            'codigo_de_reparto' => 'required|string|unique:repartos,codigo_de_reparto',
            'fecha_entrega'     => 'required|date|after_or_equal:today',
            'vehiculo_id'       => 'required|exists:vehiculos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_entrega.required'        => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.date'            => 'La fecha de entrega debe ser una fecha válida',
            'fecha_entrega.after_or_equal'  => 'La fecha de entrega no puede ser anterior a la fecha de creación.',
            'vehiculo_id.required'          => 'El vehículo es obligatorio.',
            'vehiculo_id.exists'            => 'El vehículo seleccionado no existe.'
        ];
    }
}
