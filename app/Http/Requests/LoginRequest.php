<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

    class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password' =>'required|string',
            'usuario' => 'required|string|lowercase',
        ];
    }

    public function attributes()
    {
        return [
            'password'=> '[contraseña]',
            'usuario' => '[nombre de usuario]',
            'remember' => '[Recordar cuenta del usuario]'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio llenarlo.',
            // 'email' => 'El campo :attribute esta escrito incorrectamente.',
            'boolean' => 'El campo :attribute debe de ser de tipo booleano.',
            'string' => 'El campo :attribute debe ser de tipo string.',
            'lowercase' => 'El :attribute debe ser minusculas.'
        ];
    }
}
