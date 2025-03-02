<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearActaRequest extends FormRequest
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
            'partido' => 'required|string|max:255',
            'jugador' => 'required|string|max:255',
            'incidencia' => 'required|in:goles,asistencias,tarjetas_amarillas,tarjetas_rojas,lesiones',
            'comentario' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'partido.required' => 'El partido de incidencia es requerido.',
            'partido.string' => 'El partido de la incidencia ha de ser texto.',
            'partido.max' => 'El partido solo tiene maximo 255 caracteres.',
            'jugador.required' => 'El jugador de incidencia es requerido.',
            'jugador.string' => 'El jugador de la incidencia ha de ser texto.',
            'jugador.max' => 'El jugador solo tiene maximo 255 caracteres.',
            'incidencia.required' => 'El tipo de incidencia es requerido.',
            'incidencia.required' => 'Los valores del tipo de incidencia son [goles | asistencias | tarjetas_amarillas | tarjetas_rojas | lesiones]',
            'comentario.string' => 'El comentario de la incidencia ha de ser texto.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Errores en la actualización de la acta',
            'errors' => $validator->errors()
        ]));
    }
}
