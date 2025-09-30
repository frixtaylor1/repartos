<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignarRepartoRequest extends FormRequest
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
            'reparto_id' => 'required|exists:repartos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'reparto_id.required' => 'El ID del reparto es obligatorio.',
            'reparto_id.exists' => 'El reparto especificado no existe.',
        ];
    }
}
