<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPatrocinadorRequest extends FormRequest
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
            'nombre' => 'required|string|max:45',
            'equipo' => 'required|string|max:45',
        ];
    }

    public function messages()
    {
        return [
            'nombre.max' => 'El nombre del patrocinador del equipo es requerido.',
            'nombre.string' => 'El nombre del patrocniador del equipo ha de ser texto.',
            'nombre.required' => 'El nombre del patrocniador del equipo solo tiene maximo 45 caracteres.',
            'equipo.max' => 'El nombre del equipo es requerido.',
            'equipo.string' => 'El nombre del equipo ha de ser texto.',
            'equipo.required' => 'El nombre del equipo solo tiene maximo 45 caracteres.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Errores en la creacion de un patrocinador',
            'errores' => $validator->errors()
        ]));
    }
}
