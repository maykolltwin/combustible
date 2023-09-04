<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $hidden = ['created_at', 'updated_at']; 
    protected $fillable = ['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 'expediente', 'carne'];

    // public function vehiculoAsignados()
    // {
    //     return $this->hasMany(VehiculoAsignado::class);
    // }   
}
