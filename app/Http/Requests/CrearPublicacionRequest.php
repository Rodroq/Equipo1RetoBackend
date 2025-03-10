<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CrearPublicacionRequest extends FormRequest
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
            'titulo' => 'required|string|max:45',
            'slug' => 'required|string',
            'tipo' => 'required|in:equipos,jugadores,ongs,pabellones,partidos,patrocinadores,retos',
            'texto' => 'required|string',
            'portada' => 'boolean',
            'rutaaudio' => 'string',
            'rutavideo' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El titulo de la publicacion es requerido.',
            'titulo.string' => 'El titulo de la publicacion ha de ser texto.',
            'slug.required' => 'El slug de la publicacion es requerido.',
            'slug.string' => 'El slug de la publicacion ha de ser texto.',
            'tipo.required' => 'El tipo de la publicacion es requerido.',
            'tipo.in' => 'Los valores del tipo de publicacion son [equipos | jugadores | ongs | pabellones | partidos | patrocinadores | retos]',
            'titulo.max' => 'El titulo solo tiene maximo 45 caracteres.',
            'texto.required' => 'El texto de la publicacion es requerido.',
            'texto.string' => 'El texto de la publicacion ha de ser texto.',
            'portadao.boolean' => 'El nombre del jugador ha de ser texto.',
            'rutaaudio.string' => 'La ruta del audio de la publicacion ha de ser texto.',
            'rutavideo.string' => 'La ruta del video de la publicacion ha de ser texto.'
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
