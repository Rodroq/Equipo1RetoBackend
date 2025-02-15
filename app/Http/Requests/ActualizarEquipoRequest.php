<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'nombre' => 'string|max:45',
            'grupo' => 'in:A,B',
            'centro_id' => 'numeric|exists:centros,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre del equipo ha de ser texto',
            'nombre.max' => 'El nombre solo tiene maximo 45 caracteres',
            'grupo.in' => 'El grupo solo puede ser [A | B]',
            'centro_id.numeric' => 'El centro no es valido',
            'centro_id.exists' => 'El centro no existe',
        ];
    }

    /* Agregar para devolver los mensajes de error a traves de la API */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
