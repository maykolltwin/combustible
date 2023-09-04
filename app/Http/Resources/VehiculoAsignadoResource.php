<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoAsignadoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'vehiculo' => $this->vehiculo,
            'persona'   => $this->persona
        ];
    }
}
