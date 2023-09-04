<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegistrerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'usuario' => 'required|string|lowercase|unique:pgsql.autenticacion.users,usuario',
            'estado' =>'string',
            'rol' =>'required|integer',
            'password' => 'required|string',
            // 'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),],
        ];
    }

    public function attributes()
    {
        return [
            'usuario'=> '[nombre y apellidos del usuario]',
            'password' => '[contraseña]',
            'estado' => '[estado del usuario]',
            'rol' => '[rol del usuario]'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio llenarlo.',
            'unique' => 'El campo :attribute ya existe en la Base de Datos.',
            'boolean' => 'El campo :attribute debe de ser de tipo booleano.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'string' => 'El campo :attribute debe ser de tipo string.',
            'lowercase' => 'El :attribute debe ser minusculas.',
        ];
    }
}
