<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Resources\AuditoriaResource;
use App\Models\auditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuditoriaController extends Controller
{
    //Mostrar las trazas de lso
    public function index($pdf = 0)
    {
        if ($pdf == 1) {
            return ReporteController::export_auditoria(auditoria::orderByDesc('id')->get());
        }
        return Helpers::BackResponse(AuditoriaResource::collection(auditoria::orderByDesc('id')->get()),
                    'Operación de consulta satisfactoria.', 200, true);
    }

    //Registrar las acciones del usuario en la aplicacion
    public static function auditoria($accion,$user)
    {
        $auditoria = new auditoria();
        $auditoria->accion = $accion;
        $auditoria->user_id = $user;
        $auditoria->save();
    }


    //Buscar una auditoria x fecha y usuario
    public function show_request(Request $request, $pdf=0)
    {
        $arrayRequest = $request->toArray();
        $llaves = array_keys($arrayRequest);
        $cod = 200;
        $modelo = collect();
        for ($i = 0; $i < sizeof($llaves); $i++) {
            switch ($llaves[$i]) {
                case 'fecha':
                    $anio = date('Y', strtotime($request->fecha));
                    $mes = date('m', strtotime($request->fecha));
                    $dia = date('d', strtotime($request->fecha));
                    if ($i === 0) {
                    $modelo = auditoria::whereYear('created_at', '=', $anio)->whereMonth('created_at', '=', $mes)->whereDay('created_at', '=', $dia)->get();
                    }
                    else{
                        $modelo = $modelo->intersect(auditoria::whereYear('created_at', '=', $anio)->whereMonth('created_at', '=', $mes)->whereDay('created_at', '=', $dia)->get());
                    }
                    break;
                case 'usuario':
                    if ($i === 0) {
                        $modelo = auditoria::where('user_id', $request->usuario)->get();
                    }else $modelo = $modelo->intersect(auditoria::where('user_id', $request->usuario)->get());
                    break;
                case 'accion':
                    if ($i === 0) {
                        $modelo = auditoria::where('accion','LIKE','%'.Str::lower($request->accion).'%')->get();
                    }else $modelo = $modelo->intersect(auditoria::where('accion','LIKE','%'.Str::upper($request->accion).'%')->get());
                    break;
                case 'fecha_ini':
                    $inicio = strtotime($request->fecha_ini);
                        $fin = strtotime($request->fecha_fin);
                    if ($i === 0) {
                        $modelo = auditoria::whereDate('created_at', '>=', carbon::parse($inicio))
                        ->whereDate('created_at', '<=', carbon::parse($fin))
                        ->get();
                    }else $modelo = $modelo->intersect(auditoria::whereDate('created_at', '>=', carbon::parse($inicio))
                                    ->whereDate('created_at', '<=', carbon::parse($fin))
                                    ->get());
                    break;
            }
        }

        if ($modelo->first() == null) $cod = 203;

        if ($pdf == 1) {
            return ReporteController::export_auditoria($modelo);
        }
        return Helpers::BackResponse(AuditoriaResource::collection($modelo),
        'Operación de busqueda satisfactoria.', $cod, true);
    }

}
