<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class vehiculoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'type' => 'Vehiculo',
            'id' => $this->id,
            'attributes' => parent::toArray($request),
            // 'relationships' => [
            //     'persona' => [
            //         'data' => [
            //             'type' => 'Persona',
            //             'id' => $this->persona->id
            //         ]
            //     ]
            // ]
            // 'persona' => $this->persona
            // 'persona' => $this->whenLoaded('persona'),
        ];
    }

    public function with($request)
    {
        return [
            'included' => [
                'type' => 'Persona',
                'id' => $this->whenNotNull($this->persona_id),
                'attributes' => $this->whenNotNull($this->persona)
            ]
        ];
    }
}
