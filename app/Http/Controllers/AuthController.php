<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helpers;

use App\Http\Requests\RegistrerRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AuditoriaController;
use App\Models\rol;
use App\Models\Token;

class AuthController extends Controller
{
    //Registrar de usuario
    public function register_new(RegistrerRequest $request)
    {
        $user = new User();
        $user->nombres = $request->nombre;
        $user->usuario = $request->usuario;
        $user->estado = true;
        $user->rol_id = $request->rol;
        $user->password = Hash::make($request->password);
        $user->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Registrar un usuario', $user);

        return Helpers::BackResponse(new UserResource($user),
                        'Usuario creado satisfactoriamente.', 201, true);
    }

    //Mostrar todos los usuarios
    public function index()
    {
        return Helpers::BackResponse(UserResource::collection(user::orderByDesc('id')->get()),
                        'Operación de consulta satisfactoria.', 200, true);
    }

    //Modificar usuarios
    public function update(UserRequest $request, user $modelo)
    {
        $rol = rol::where('rol', $request->rol)->first();
        $modelo->nombres = $request->nombre? $request->nombre: $modelo->nombres;
        $modelo->usuario = $request->usuario? $request->usuario: $modelo->usuario;
        $modelo->rol_id = $rol->id? $rol->id: $modelo->rol_id;
        $modelo->update();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Actualizar usuario', $user);

        return Helpers::BackResponse(new UserResource($modelo),
                    'Operación de actualizar satisfactoria.', 200, true);
    }

    //Desactivar usuarios
    public function desact_user(User $modelo, Request $request)
    {
        $modelo->estado = false;
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Desactivar usuario', $user);

        return Helpers::BackResponse(new UserResource($modelo),
        'Usuario desactivado satisfactoriamente.', 200, true);
    }

    //Activar usuarios
    public function act_user(User $modelo, Request $request)
    {
        $modelo->estado = true;
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Activar usuario', $user);

        return Helpers::BackResponse(new UserResource($modelo),
        'Usuario activado satisfactoriamente.', 200, true);
    }

    //Cambiar la contraseña a un usuario
    public function cambiar_password_new(Request $request)
    {
        $token = Token::where('token', $request->header('X-Authorization'))->first();
        $user_new = User::find($token->user_id);
        $user_new->password = Hash::make($request->new_password);
        $user_new->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Cambiar contraseña de usuario', $user);

        return Helpers::BackResponse(new UserResource($user_new),
                    'Contraseña cambiada correctamente.', 201, true);
    }

    //Resetear contraseña
    public function reset_password(user $modelo,Request $request)
    {
        $modelo->password = Hash::make('fa9100bc7e4ea13059ba392ebd754f7b');
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Resetear contraseña de usuario', $user);


        return Helpers::BackResponse(new UserResource($modelo),
                    'Contraseña reseteada correctamente.', 201, true);
    }
}


