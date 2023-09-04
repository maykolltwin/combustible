<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'autenticacion.users';

    protected $fillable = [
        'usuario',
        'nombres',
        'rol_id',
        'password',
        'estado',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function rol()
    {
        return $this->belongsTo(rol::class);
    }

    public function dat_ordens()
    {
        return $this->hasMany(dat_orden::class);
    }

    public function dat_auditorias()
    {
        return $this->hasMany(dat_auditoria::class);
    }

    protected function usuario(): Attribute
    {
        return new Attribute(
            get: function($value){
                return strtolower($value);
            },
            set: function($value){
                return strtolower($value);
            }
        );
    }

    protected function nombres(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }
}
