<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Requests\RolRequest;
use App\Http\Requests\RolUpdateRequest;
use App\Http\Resources\RolResource;
use App\Models\rol;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolController extends Controller
{
    //Mostrar todos los roles
    public function index()
    {
        return Helpers::BackResponse(RolResource::collection(rol::orderByDesc('id')->get()),
        'Operación de consulta satisfactoria.', 200, true);
    }

    //Mostrar un rol
    public function show(rol $modelo)
    {
        return Helpers::BackResponse(new RolResource($modelo),
        'Operación de consulta satisfactoria.', 200, true);
    }

    //Buscar un rol x cualquier campo
    public function show_request(Request $request)
    {
        $arrayRequest = $request->toArray();
        $llaves = array_keys($arrayRequest);
        $valores = array_values($arrayRequest);
        $cod = 200;
        $modelo = collect();
        for ($i = 0; $i < sizeof($llaves); $i++) {
            switch ($llaves[$i]) {
                case 'identificador':
                    if ($i === 0) {
                        $modelo = rol::where('id',Str::upper($valores[$i]))->get();
                    }else $modelo = $modelo->intersect(rol::where('id',Str::upper($valores[$i]))->get());
                    break;
                case 'rol':
                    if ($i === 0) {
                        $modelo = rol::where('rol','LIKE','%'.Str::upper($valores[$i]).'%')->get();
                    }else $modelo = $modelo->intersect(rol::where('rol','LIKE','%'.Str::upper($valores[$i]).'%')->get());
                    break;
                case 'estado':
                    if ($i === 0) {
                        $modelo = rol::where('estado',Str::upper($valores[$i]))->get();
                    }else $modelo = $modelo->intersect(rol::where('estado', Str::upper($valores[$i]))->get());
                    break;
            }
        }

        if ($modelo->first() == null) $cod = 203;

        return Helpers::BackResponse(RolResource::collection($modelo),
                    'Operación de búsqueda satisfactoria.', $cod, true);
    }

    //Crear un rol
    public function store(RolRequest $request)
    {
        $modelo = new rol();
        $modelo->rol = $request->rol;
        $modelo->estado = true;
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Crear un rol', $user);

        return Helpers::BackResponse(new RolResource($modelo),
                    'Operación de crear satisfactoria.', 201, true);
    }

    //Actualizar un rol
    public function update(RolUpdateRequest $request, rol $modelo)
    {
        $modelo->rol = $request->rol;
        $modelo->update();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Actualizar un rol', $user);

        return Helpers::BackResponse(new RolResource($modelo),
        'Operación de actualizar satisfactoria.', 200, true);
    }

    //Activar un rol
    public function act_rol(Request $request, rol $modelo)
    {
        $modelo->estado = true;
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Activar un rol', $user);

        return Helpers::BackResponse(new RolResource($modelo),
        'Operación de activar satisfactoria.', 200, true);
    }

    //Desactivar un rol
    public function desact_rol(Request $request, rol $modelo)
    {
        $modelo->estado = false;
        $modelo->save();

        //Auditoria
        $user = Helpers::user_log($request->header('X-Authorization'));
        AuditoriaController::auditoria('Desactivar un rol', $user);

        return Helpers::BackResponse(new RolResource($modelo),
        'Operación de desactivar satisfactoria.', 200, true);
    }
}
