<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarUsuarioRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'string|max:255',
            'email' => 'string|email|max:255',
            'password' => 'nullable|string|min:8',
            'rol' => 'string|in:administrador,entrenador,periodista',
        ];
    }

    /**
     * Obtiene los mensajes personalizados para los errores de validación.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre del jugador ha de ser texto.',
            'nombre.max' => 'El nombre solo tiene maximo 255 caracteres.',
            'email.email' => 'El email no corresponde con un formato valido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'rol.in' => 'Los valores del tipo de usuario son [administrador | entrenador | periodista]',
        ];
    }

    /* Agregar para devolver los mensajes de error a traves de la API */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la actualizacion del usuario',
            'errors'      => $validator->errors()
        ]));
    }
}
