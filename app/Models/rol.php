<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class rol extends Model
{
    use HasFactory;

    protected $table = 'autenticacion.rols';

    protected $fillable = [
        'id',
        'rol',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    protected function rol(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }
}
