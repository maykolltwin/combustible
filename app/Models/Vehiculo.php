<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $hidden = ['created_at', 'updated_at']; 
    protected $fillable = ['matricula', 'descripcion'];

    // public function vehiculoAsignado()
    // {
    //     return $this->hasOne(vehiculoAsignado::class);
    // }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}