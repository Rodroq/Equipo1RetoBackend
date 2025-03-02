<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarActaRequest extends FormRequest
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
            'incidencia' => 'string|in:goles,asistencias,tarjetas_amarillas,tarjetas_rojas,lesiones',
            'comentario' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'incidencia.string' => 'La incidencia ha de ser texto.',
            'incidencia.in' => 'Los valores del tipo de incidencia son [goles | asistencias | tarjetas_amarillas | tarjetas_rojas | lesiones]',
            'comentario.string' => 'El comentario de la incidencia ha de ser texto.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => 'Errores en la actualizacion de la acta',
            'errors' => $validator->errors()
        ]));
    }
}
