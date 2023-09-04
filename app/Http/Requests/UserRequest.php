<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('modelo')['id'];
        return [
            'usuario' => 'required|string|lowercase|unique:pgsql.autenticacion.users,usuario,'.$id
        ];
    }

    public function attributes()
    {
        return [
            'usuario' => '[nombre de usuario]',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio llenarlo.',
            'string' => 'El campo :attribute debe ser de tipo string.',
            'lowercase' => 'El :attribute debe ser minusculas.'
        ];
    }
}
