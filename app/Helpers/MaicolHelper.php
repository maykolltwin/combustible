<?php

namespace App\Helpers;

class MaicolHelper {
    public static function Buscar($request, $modelo, &$cant){
        foreach ($request as $key => $value) {
            $filter[] = [$key, $value];
        }
        $data = $modelo::where($filter)->get();
        $cant = $data->count();
        return $data;
    }

    public static function responseResource($resource, $modelo, $state, $code, $message){
        return $resource::collection($modelo)->additional([
            'state' => $state,
            'code' => $code,
            'message' => $message
            ]
        )->response()->setStatusCode($code);
    }

    public static function dataNotFound(&$modelo, &$state, &$code, &$message, string $string){
        $modelo = [];
        $state = false;
        $code= 404;
        $message = $string;
    }
}

class MaicolCrud{
    public static function prueba(){
        return 'prueba ok';
    }
}