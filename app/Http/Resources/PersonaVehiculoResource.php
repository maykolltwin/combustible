<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonaVehiculoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        
        return [
            'persona' => parent::toArray($request),
            'persona' => $this->persona,
            // 'vehiculo' => $this->vehiculo
        ] ;
    }
}