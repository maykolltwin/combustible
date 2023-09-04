<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $hidden = ['created_at', 'updated_at']; 
    protected $fillable = ['numero', 'descripcion', 'abreviatura'];
}