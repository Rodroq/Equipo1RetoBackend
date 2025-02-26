<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipoResource extends JsonResource
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
            'nombre' => $this->nombre,
            'grupo' => $this->grupo,
            'centro' => [
                'nombre' => $this->centro->nombre
            ],
            'jugadores' => JugadorResource::collection($this->jugadores),
        ];
    }
}
