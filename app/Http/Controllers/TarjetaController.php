<?php

namespace App\Http\Controllers;

use App\Helpers\MaicolHelper;
use App\Http\Resources\TarjetaResource;
use App\Models\Tarjeta;
use Faker\Factory;
use Illuminate\Http\Request;

class TarjetaController extends Controller
{
    public function show(Request $request){
        if ($request->meta['all'] === true) {
            $modelo = Tarjeta::all();
            $cant = $modelo->count();
        } else {
            $modelo = MaicolHelper::Buscar($request->filter, Tarjeta::class, $cant);
        }

        if ($cant > 0) {
            $code = 200;
            $state = true;
            $message = 'Consulta satisfactoria.  Registros obtenidos: '.$cant;
            
            if ($request->meta['data_pag'] > 0) {
                $modelo = $modelo->toQuery()->paginate($request->meta['data_pag']);
            };
        } else {
            MaicolHelper::dataNotFound($modelo, $state, $code, $message, 'No se encontraron datos para mostrar.');
        }

        return MaicolHelper::responseResource(TarjetaResource::class, $modelo, $state, $code, $message);
    }

    public function store(Request $request){
        if ($request->meta['faker'] === true) {
            $faker_count = $request->meta['faker_count'];
            if ($faker_count > 0) {
                for ($i=1; $i <= $faker_count ; $i++) { 
                    $faker = Factory::create();
                    $data = new Tarjeta;
                    $data->numero = $faker->regexify('[0-9]{16}');
                    $data->saldo = $faker->randomFloat(2, 1, 99);
                    $data->descripcion = $faker->sentence();
                    $data->save();
                    $id[] = $data->id;
                    $cant = $i;
                }
            }
        } else {
            if ($request->meta['several'] === true) {
                $cant = 0;
                foreach ($request->store as $value) {
                    $cant++;
                    $data = Tarjeta::create($value);
                    $id[] = $data->id;
                }
            } else {
                $cant = 1;
                $data = Tarjeta::create($request['store']);
                $id[] = $data->id;
            }
        }

        if ($cant > 0) {
            $code = 201;
            $state = true;
            $message = 'Creación satisfactoria.  Registros creados: '.$cant;
            
            if ($request->meta['data'] === true) {
                $modelo = Tarjeta::whereIn('id', $id)->get();
                if ($request->meta['data_pag'] > 0) {
                    $modelo = $modelo->toQuery()->paginate($request->meta['data_pag']);
                }
            } else {
                $modelo = [];
                $code = 202;
            }
        } else {
            MaicolHelper::dataNotFound($modelo, $state, $code, $message, 'No se encontraron datos para crear.');
        }

        return MaicolHelper::responseResource(TarjetaResource::class, $modelo, $state, $code, $message);
    }
    
    public function update(Request $request){
        if ($request->meta['all'] === true) {
            $modelo = Tarjeta::all();
            $cant = $modelo->count();
        } else {
            $modelo = MaicolHelper::Buscar($request->filter, Tarjeta::class, $cant);
        }

        if ($cant>0) {
            $modelo->toQuery()->update($request->meta['update']);
            $code = 200;
            $state = true;
            $message = 'Actualización satisfactoria.  Registros actualizados: '.$cant;
            
            if ($request->meta['data'] === true) {
                if ($request->meta['data_pag'] > 0) {
                    $modelo = $modelo->toQuery()->paginate($request->meta['data_pag']);
                }
            }else {
                $modelo = [];
                $code = 202;
            }
        }else {
            MaicolHelper::dataNotFound($modelo, $state, $code, $message, 'No se encontraron datos para actualizar.');
        }
        
        return MaicolHelper::responseResource(TarjetaResource::class, $modelo, $state, $code, $message);
    }

    public function delete(Request $request){
        if ($request->meta['all'] === true) {
            $modelo = Tarjeta::all();
            $cant = $modelo->count();
        } else {
            $modelo = MaicolHelper::Buscar($request->filter, Tarjeta::class, $cant);
        }

        if ($cant > 0) {
            $code = 200;
            $state = true;
            $message = 'Eliminación satisfactoria.  Registros eliminados: '.$cant;
            
            if ($request->meta['data'] === true) {
                if ($request->meta['data_pag'] > 0) {
                    $modelo = $modelo->toQuery()->paginate($request->meta['data_pag']);
                };
            }

            if ($request->meta['all'] === true && $request->meta['all_reset'] === true) {
                $modelo->toQuery()->truncate();
            } else {
                $modelo->toQuery()->delete();
            }

            if ($request->meta['data'] === false) {
                $modelo = [];
                $code = 202;
            }
        } else {
            MaicolHelper::dataNotFound($modelo, $state, $code, $message, 'No se encontraron datos para eliminar.');
        }

        return MaicolHelper::responseResource(TarjetaResource::class, $modelo, $state, $code, $message);
    }
}