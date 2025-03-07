<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ActualizarPublicacionRequest extends FormRequest
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
            'titulo' => 'string|max:45',
            'texto' => 'string',
            'portada' => 'boolean',
            'rutaaudio' => 'string|max:255',
            'rutavideo' => 'string|max:255',
        ];
    }


    public function messages(): array
    {
        return [
            'titulo.string' => 'El titulo de la publicacion ha de ser texto.',
            'titulo.max' => 'El titulo solo tiene maximo 45 caracteres.',
            'texto.string' => 'El texto de la publicacion ha de ser texto.',
            'portadao.boolean' => 'El nombre del jugador ha de ser texto.',
            'rutaaudio.string' => 'La ruta del audio de la publicacion ha de ser texto.',
            'rutaaudio.max' => 'La ruta del audio solo tiene maximo 255 caracteres.',
            'rutavideo.string' => 'La ruta del video de la publicacion ha de ser texto.',
            'rutavideo.max' => 'La ruta del video solo tiene maximo 255 caracteres.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Errores en la creacion de la publicacion',
            'errors'      => $validator->errors()
        ]));
    }
}
