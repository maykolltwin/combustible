<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'identificador'=> $this->id,
            'rol' => $this->rol,
            'estado' => $this->when($this->estado, 'Activado','Desactivado')
        ];
    }
}
