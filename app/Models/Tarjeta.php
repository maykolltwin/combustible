<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $hidden = ['created_at', 'updated_at']; 
    protected $fillable = ['numero', 'saldo', 'descripcion'];
}