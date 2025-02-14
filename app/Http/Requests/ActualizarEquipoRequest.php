<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarEquipoRequest extends FormRequest
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
            'nombre' => 'max:45',
            'grupo' => 'in:A,B',
            'centro_id' => 'numeric|exists:centros,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.max' => 'El nombre solo tiene maximo 45 caracteres',
            'grupo.in' => 'Los grupos permitidos son [A,B]',
            'centro_id.numeric' => 'El centro no es valido',
            'centro_id.exists' => 'El centro no existe',
        ];
    }
}
