<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'equipoL' => $this->equipoLoc->nombre,
            'equipoV' => $this->equipoVis->nombre,
            'golesL' => $this->golesL,
            'golesV' => $this->golesV,
            'pabellon' => $this->pabellon ? $this->pabellon->nombre : null,
        ];
    }
}
