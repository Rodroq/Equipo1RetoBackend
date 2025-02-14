<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearEquipoRequest extends FormRequest
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
            'nombre' => 'required|max:45',
            'grupo' => 'in:A,B',
            'centro_id' => 'numeric|exists:centros,id',
            'jugadores' => 'required|array',
            'jugadores.*.nombre' => 'required|string|max:45',
            'jugadores.*.apellido1' => 'string|max:45',
            'jugadores.*.apellido2' => 'string|max:45',
            'jugadores.*.tipo' => 'required|in:jugador,capitan,entrenador',
            'jugadores.*.dni' => 'string|max:9',
            'jugadores.*.email' => 'string|max:45',
            'jugadores.*.telefono' => 'string|max:45',
            'jugadores.*.goles' => 'integer',
            'jugadores.*.asistencias' => 'integer',
            'jugadores.*.tarjetas_amarillas' => 'integer',
            'jugadores.*.tarjetas_rojas' => 'integer',
            'jugadores.*.lesiones' => 'integer'
        ];
    }

    public function messages():array
    {
        return [
            'nombre.required' => 'El nombre del equipo es requerido',
            'nombre.max' => 'El nombre solo tiene maximo 45 caracteres',
            'grupo.in' => 'Los grupos permitidos son [A,B]',
            'centro_id.numeric' => 'El centro no es valido',
            'centro_id.exists' => 'El centro no existe',
            'jugadores.required' => 'A de incluir a al menos 1 jugador',
            'jugadores.array' => 'Formato de jugadores no permitido',
            'jugadores.*.nombre.required' => 'El nombre del jugador es requerido',
            'jugadores.*.nombre.string' => 'El nombre del jugador ha de ser texto',
            'jugadores.*.nombre.max' => 'El nombre del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.apellido1.string' => 'El apellido1 del jugador ha de ser texto',
            'jugadores.*.apellido1.max' => 'El apellido1 del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.apellido2.string' => 'El apellido2 del jugador ha de ser texto',
            'jugadores.*.apellido2.max' => 'El apellido2 del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.tipo.required' => 'El tipo del jugador es requerido',
            'jugadores.*.tipo.in' => 'Los valores del tipo de jugador son [jugador,capitan,entrenador]',
            'jugadores.*.dni.string' => 'El dni del jugador ha de ser texto',
            'jugadores.*.dni.max' => 'El dni del jugador solo tiene máximo 9 caracteres',
            'jugadores.*.email.string' => 'El email del jugador ha de ser texto',
            'jugadores.*.email.max' => 'El email del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.telefono.string' => 'El telefono del jugador ha de ser texto',
            'jugadores.*.telefono.max' => 'El telefono del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.goles.integer' => 'Los goles del jugador solo tiene máximo 45 caracteres',
            'jugadores.*.asistencias.integer' => 'Las asistencias del jugador han de ser valores numéricos',
            'jugadores.*.tarjetas_amarillas.integer' => 'las tarjetas amarillas del jugador han de ser valores numéricos',
            'jugadores.*.tarjetas_rojas.integer' => 'Las tarjetas rojas del jugador han de ser valores numéricos',
            'jugadores.*.lesiones.integer' => 'las lesiones del jugador han de ser valores numéricos',
        ];
    }
}
