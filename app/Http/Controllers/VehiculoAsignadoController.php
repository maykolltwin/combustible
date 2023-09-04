<?php

namespace App\Http\Controllers;

use App\Helpers\MaicolCrud;
use App\Helpers\MaicolFramework;
use App\Helpers\MaicolHelper;
use App\Http\Resources\PersonaResource;
use App\Http\Resources\PersonaVehiculoResource;
use App\Http\Resources\VehiculoAsignadoResource;
use App\Http\Resources\VehiculoPersonaCollection;
use App\Http\Resources\VehiculoPersonaResource;
use App\Http\Resources\vehiculoResource;
use App\Models\Persona;
use App\Models\Vehiculo;
use App\Models\VehiculoAsignado;
use Illuminate\Http\Request;

class VehiculoAsignadoController extends Controller
{
    public function asignar(Request $request){
        $modelo = VehiculoAsignado::create($request->all());
        return MaicolHelper::responseResource(VehiculoAsignadoResource::class, [$modelo], $state=true, $code=200, $message='Vehículo asignado correctamente.');
    }

    public function reasignar(Request $request){
        $modelo = VehiculoAsignado::where($request->filter['vehiculo_id']);
        $modelo->update($request->update);
        return MaicolHelper::responseResource(VehiculoAsignadoResource::class, [$modelo], $state=true, $code=200, $message='Vehículo asignado correctamente.');
    }

    public function eliminar(Request $request){
        $modelo = VehiculoAsignado::where('vehiculo_id', $request->filter['vehiculo_id'])->
                                    where('persona_id', $request->filter['persona_id']);
        $data = $modelo->get();
        $modelo->delete();
        return MaicolHelper::responseResource(VehiculoAsignadoResource::class, $data, $state=true, $code=200, $message='Vehículo sin asignación.');
    }

    public function show(Request $request){      
        return MaicolCrud::show(VehiculoAsignado::class, VehiculoAsignadoResource::class, $request->filter, $request->pag, $request->order, $request->show, $request->meta);
    }

    public function showVehiculoPersona(Request $request){
        // $modelo = VehiculoAsignado::find($request->filter['vehiculo_id']);
        // $modelo = VehiculoAsignado::where('id', $request->filter['vehiculo_id'])->get();
        
        // $modelo = VehiculoAsignado::paginate(1);
        // $modelo = VehiculoAsignado::all();
        
        // return VehiculoPersonaResource::collection($modelo);
        // return new VehiculoPersonaResource($modelo);
        
        // return new VehiculoPersonaCollection($modelo);
        // return VehiculoPersonaCollection::collection($modelo);


        $modelo = Vehiculo::find($request->filter['vehiculo_id']);
        return new vehiculoResource($modelo);
        return $modelo;
    }

    public function showPersonaVehiculo(Request $request){
        $persona = VehiculoAsignado::where($request->filter);
        // $persona = $persona->unique('persona_id');
        return MaicolCrud::showResource($persona, PersonaVehiculoResource::class, $request->pag, $request->order, $request->show, $request->meta);
        // return $data = Persona::where('id', 1)->get();
        // return MaicolCrud::show(VehiculoAsignado::class, PersonaVehiculoResource::class, $request->filter, $request->pag, $request->order, $request->show, $request->meta);
    }
}