<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'identificador'=> $this->id,
            'nombre' => $this->nombres,
            'usuario' => $this->usuario,
            'estado' => Str::ucfirst($this->when($this->estado, 'Activo','Inactivo')),
            'rol' => $this->rol->rol,
        ];
    }
}
