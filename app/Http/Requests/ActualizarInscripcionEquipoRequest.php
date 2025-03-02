<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarInscripcionEquipoRequest extends FormRequest
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
            'comentario' => 'string',
            'estado' => 'in:pendiente,aprobada,rechazada',
            /* ¿Permitir actualizar tambien el centro? */
        ];
    }

    public function messages(): array
    {
        return [
            'comentario.string' => 'El comentario de la inscripcion del equipo ha de ser texto.',
            'grupo.in' => 'El comentario de la inscripcion del equipo solo puede ser [pendiente | aprobada | rechazada].',
        ];
    }

    /* Agregar para devolver los mensajes de error a traves de la API */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la actualizacion de la inscripcion del equipo',
            'errors'      => $validator->errors()
        ]));
    }
}
