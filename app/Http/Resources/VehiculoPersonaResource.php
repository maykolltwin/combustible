<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoPersonaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'type'  =>  'Vehiculo',
            'id'    =>  $this->vehiculo->id,
            'attributes' => $this->vehiculo,
            'relationships' => [
                'persona' => [
                    'data' => [
                        'type' => 'Persona',
                        'id' => $this->persona->id
                    ]
                ]
            ]
        ];
    }

    public function with($request)
    {
        return [
            'included' => [
                // ['type' => 'Vehiculo',
                // 'id' => $this->vehiculo->id,
                // 'attributes' => $this->vehiculo],
                ['type' => 'Persona',
                'id' => $this->persona->id,
                'attributes' => $this->persona]
            ]
        ];
    }
}