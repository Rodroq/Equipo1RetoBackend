<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPartidoRequest extends FormRequest
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
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
            'equipoLoc' => 'required|exists:equipos,id',
            'equipoVis' => 'required|exists:equipos,id|different:equipoL',
            'golesL' => 'nullable|integer|min:0',
            'golesV' => 'nullable|integer|min:0',
            'pabellon_id' => 'nullable|exists:pabellones,id',
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'El formato de la fecha debe ser YYYY-MM-DD.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'El formato de la hora debe ser HH:MM:SS.',
            'equipoL.required' => 'El equipo local es obligatorio.',
            'equipoL.exists' => 'El equipo local no existe.',
            'equipoV.required' => 'El equipo visitante es obligatorio.',
            'equipoV.exists' => 'El equipo visitante no existe.',
            'equipoV.different' => 'El equipo visitante debe ser diferente al equipo local.',
            'golesL.integer' => 'Los goles del equipo local deben ser un número entero.',
            'golesV.integer' => 'Los goles del equipo visitante deben ser un número entero.',
            'pabellon_id.exists' => 'El pabellón seleccionado no es válido.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la creacion',
            'errors'      => $validator->errors()
        ]));
    }
}
