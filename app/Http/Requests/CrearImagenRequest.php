<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearImagenRequest extends FormRequest
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
            'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'La imagen del equipo es requerido.',
            'image.mimes' => 'Los tipos de imagen permitidos son [png,jpg,jpeg,gif]',
            'image.max' => 'El tamaño maximo de la imagen debe rondar los 2 MB.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la creacion de la imagen',
            'errors'      => $validator->errors()
        ]));
    }
}
