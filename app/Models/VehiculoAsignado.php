<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiculoAsignado extends Model
{
    protected $hidden = ['created_at', 'updated_at']; 
    protected $fillable = ['persona_id', 'vehiculo_id'];

    public function vehiculo()
    {
        return $this->belongsTo(vehiculo::class);
    }

    public function persona()
    {
        return $this->belongsTo(persona::class);
    }
}