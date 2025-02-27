<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ImagenRequest extends FormRequest
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
            'imagen' => 'required|mimes:png,jpg,jpeg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'imagen.required' => 'La imagen es requerida.',
            'imagen.mimes' => 'Los tipos de imagen permitidos son [png,jpg,jpeg]',
            'imagen.max' => 'El tamaño maximo de la imagen debe rondar los 2 MB.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la imagen',
            'errors'      => $validator->errors()
        ]));
    }
}
