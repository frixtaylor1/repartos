<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearOrdenRequest extends FormRequest
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
            'fecha_entrega' => 'required|date|after_or_equal:today',
            'cliente_id'      => 'required|exists:clientes,id',
            'codigo_de_orden' => 'required|string|unique:ordenes,codigo_de_orden',
        ];
    }
    
    public function messages(): array
    {
        return [
            'fecha_entrega.required'        => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.date'            => 'La fecha de entrega debe ser una fecha válida.',
            'fecha_entrega.after_or_equal'  => 'La fecha de entrega no puede ser anterior a la fecha de creación.',
            'cliente_id.required'           => 'El cliente es obligatorio.',
            'cliente_id.exists'             => 'El cliente seleccionado no existe.',
            'codigo_de_orden.required'      => 'El código de orden es obligatorio.',
            'codigo_de_orden.unique'        => 'El código de orden ya está en uso.',
        ];
    }
}
