<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('modelo')['id'];
        return [
            'rol' => 'required|regex:/[a-z ]+/i|unique:pgsql.autenticacion.rols,rol,'.$id,
        ];
    }

    public function attributes()
    {
        return [
            'rol' => '[nombre del rol]'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio llenarlo.',
            'unique' => 'El campo :attribute ya existe en la Base de Datos.',
            'regex' => 'El campo :attribute tiene problemas en su estructura.',
        ];
    }
}
