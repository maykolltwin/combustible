<?php

namespace App\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;

class MaicolCrud{    
    
    public static function show($class, $resource=null, $filter=null, $pag=null, $order=null, $show=null, $meta=null){
        //búsqueda de los datos
        if ($filter) {
            $data = $class::where($filter)->get();
        } else {
            $data = $class::all();
        }
        $count = $data->count();

        //ordenación de los datos
        if ($count > 0 && $order) {
            $data = $data->toQuery()->orderByRaw($order)->get();
        }

        //paginación de los datos
        if ($count > 0 && $pag && $pag>0) {
            $data = $data->toQuery()->paginate($pag);
        }
        
        //formateo de los datos (va justo delante de la transformación)
        if ($show) {
            $data->setVisible($show);
        }
        
        //transformación de los datos
        if ($resource) {
            $data = $resource::collection($data);

            //meta-respuesta
            if ($meta === null || $meta === true) {
                $data = self::responseResource($data, $count>0? true : false, $count>0? 200 : 404, $count, $count>0? 'Datos consultados satisfactoriamente.' : 'No existen datos para mostrar.');
            }
        }

        return $data;
    }

    public static function responseResource(JsonResource $data, $state, $code, $count, $message){
        return $data->additional([
            'state' => $state,
            'code' => $code,
            'count' => $count,
            'message' => $message
        ])->response()->setStatusCode($code);
    }

    public static function showResource($data, $resource=null, $pag=null, $order=null, $show=null, $meta=null){
        $count = $data->count();

        //ordenación de los datos
        if ($count > 0 && $order) {
            $data = $data->toQuery()->orderByRaw($order)->get();
        }

        //paginación de los datos
        if ($count > 0 && $pag && $pag>0) {
            $data = $data->toQuery()->paginate($pag);
        }
        
        //formateo de los datos (va justo delante de la transformación)
        if ($show) {
            $data->setVisible($show);
        }
        
        //transformación de los datos
        if ($resource) {
            $data = $resource::collection($data);

            //meta-respuesta
            if ($meta === null || $meta === true) {
                $data = self::responseResource($data, $count>0? true : false, $count>0? 200 : 404, $count, $count>0? 'Datos consultados satisfactoriamente.' : 'No existen datos para mostrar.');
            }
        }

        return $data;
    }
}