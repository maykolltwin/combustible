<?php

namespace App\Http\Resources;

use App\Helpers\BestHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'token'=> $this->token,
            'id_usuario'=> $this->user_id,
            'usuario'=> $this->user->usuario,
            'nombre'=> $this->user->nombres,
            'rol'=> $this->user->rol->rol,
            'terminal' => $this->dispositivo,
            'zona_horaria' => $this->timezone,
            'creacion'=> BestHelper::TimeZone($this->created_at, $this->timezone),
            'inicio'=> BestHelper::TimeZone(date_modify($this->created_at, $this->validez_ini), $this->timezone),
            'fin'=> BestHelper::TimeZone(date_modify($this->created_at, $this->validez_fin), $this->timezone),
            'intermedio'=> $this->validez_inter,
        ];
    }
}
