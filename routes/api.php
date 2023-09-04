<?php

use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\VehiculoAsignadoController;
use App\Models\VehiculoAsignado;
use Illuminate\Support\Facades\Route;

    //Rutas de las tabla rol
    Route::controller(RolController::class)->group(function(){
        Route::get('roles', 'index')->middleware('autenticacion');
        Route::get('roles/show/{modelo}', 'show')->middleware('autenticacion');
        Route::post('roles/show_request', 'show_request')->middleware('autenticacion');
        Route::post('roles', 'store')->middleware('autenticacion');
        Route::put('roles/{modelo}', 'update')->middleware('autenticacion');
        Route::put('roles/act_rol/{modelo}', 'act_rol')->middleware('autenticacion');
        Route::put('roles/desact_rol/{modelo}', 'desact_rol')->middleware('autenticacion');
    });

    //Rutas de las tabla usuarios
    Route::controller(AuthController::class)->group(function(){
        Route::get('users', 'index')->middleware('autenticacion');
        Route::post('register_new', 'register_new');
        Route::put('users/{modelo}', 'update')->middleware('autenticacion');
        Route::put('users/desact_user/{modelo}', 'desact_user')->middleware('autenticacion');
        Route::put('users/act_user/{modelo}', 'act_user')->middleware('autenticacion');
        Route::put('users/cambiar_password_new/nueva', 'cambiar_password_new')->middleware('autenticacion');
        Route::put('users/reset_password/reset/{modelo}', 'reset_password')->middleware('autenticacion');
    });

    Route::controller(TokenController::class)->group(function(){
        Route::put('token/login', 'login');
        Route::delete('token/logout', 'logout')->middleware('autenticacion');
    });

    //Rutas para la auditoria
    Route::controller(AuditoriaController::class)->group(function(){
        Route::get('auditoria/{pdf?}', 'index')->middleware('autenticacion');
        Route::post('auditoria/show_request/{pdf?}', 'show_request')->middleware('autenticacion');
    });

    //Rutas unidades
    Route::controller(UnidadController::class)->group(function(){
        Route::delete('unidad/delete', 'delete');
        Route::post('unidad/store', 'store');
        Route::put('unidad/update', 'update');
        Route::get('unidad/show', 'show');
    });

    //Rutas vehiculos
    Route::controller(VehiculoController::class)->group(function(){
        Route::delete('vehiculo/delete', 'delete');
        Route::post('vehiculo/store', 'store');
        Route::put('vehiculo/update', 'update');
        Route::get('vehiculo/show', 'show');
    });

    //Rutas personas
    Route::controller(PersonaController::class)->group(function(){
        Route::delete('persona/delete', 'delete');
        Route::post('persona/store', 'store');
        Route::put('persona/update', 'update');
        Route::get('persona/show', 'show');
    });

    //Rutas persona - vehiculo
    Route::controller(VehiculoAsignadoController::class)->group(function(){
        Route::post('persona/vehiculo/asignar', 'asignar');  //asignarle un vehiculo a una persona
        Route::put('persona/vehiculo/reasignar', 'reasignar');  //actualizar un vehiculo a una persona
        Route::delete('persona/vehiculo/eliminar', 'eliminar'); //eliminar asignación de vehículo a persona
        
        Route::get('persona/vehiculo/show', 'show');
        Route::get('persona/vehiculo/show-vehiculo-persona', 'showVehiculoPersona');
        Route::get('persona/vehiculo/show-persona-vehiculo', 'showPersonaVehiculo');
    });

    //Rutas tarjetas
    Route::controller(TarjetaController::class)->group(function(){
        Route::delete('tarjeta/delete', 'delete');
        Route::post('tarjeta/store', 'store');
        Route::put('tarjeta/update', 'update');
        Route::get('tarjeta/show', 'show');
    });