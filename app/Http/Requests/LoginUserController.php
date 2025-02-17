<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserController extends FormRequest
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
            'email' => ['required', 'regex:/^.+@.+$/i', 'max:255','exists:users,email'],
            'password' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El email de usuario es requerido',
            'email.regex' => 'El email no corresponde con un formato valido',
            'email.max' => 'El email solo tiene maximo 255 caracteres',
            'email.exists' => 'El usuario no existe',
            'password.required' => 'La contraseña del usuario es requerida',
            'password.string' => 'La contraseña del usuario ha de ser texto',
            'password.max' => 'La contraseña del usuario solo tiene maximo 255 caracteres',
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
