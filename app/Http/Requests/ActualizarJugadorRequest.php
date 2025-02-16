<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarJugadorRequest extends FormRequest
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
            'apellido1' => 'string|max:45',
            'apellido2' => 'string|max:45',
            'tipo' => 'in:jugador,capitan,entrenador',
            'dni' => 'regex:/^\d{8}[A-Za-z]$/',
            'email' => ['regex:/^.+@.+$/i', 'max:45'],
            'telefono' => 'string|max:45',
            'equipo' => 'required|string|max:45|exists:equipos,nombre',
            'ciclo' => 'string|exists:ciclos,nombre'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.string' => 'El nombre del jugador ha de ser texto',
            'nombre.max' => 'El nombre solo tiene maximo 45 caracteres',
            'apellido1.string' => 'El primer apellido del jugador ha de ser texto',
            'apellido1.max' => 'El primer apellido solo tiene maximo 45 caracteres',
            'apellido2.string' => 'El segundo apellido del jugador ha de ser texto',
            'apellido2.max' => 'El segundo apellido solo tiene maximo 45 caracteres',
            'tipo.in' => 'Los valores del tipo de jugador son [jugador | capitan | entrenador] ',
            'dni.regex' => 'El dni no corresponde con un formato valido',
            'email.regex' => 'El email no corresponde con un formato valido',
            'email.max' => 'El email solo tiene maximo 45 caracteres',
            'telefono.string' => 'El telefono del jugador ha de ser texto',
            'telefono.max' => 'El telefono solo tiene maximo 45 caracteres',
            'equipo.max' => 'El nombre del equipo del jugador solo tiene maximo 45 caracteres',
            'equipo.exists' => 'El equipo del jugador no existe',
            'ciclo.string' => 'El ciclo del jugador ha de ser texto',
            'ciclo.exists' => 'El ciclo del jugador no existe',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la actualizacion',
            'errors'      => $validator->errors()
        ]));
    }
}
