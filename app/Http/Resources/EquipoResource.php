<?php

namespace App\Http\Resources;

use App\Models\Centro;
use App\Models\Jugador;
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
            'nombre' => $this->nombre,
            'grupo' => $this->grupo,
            'centro' => new CentroResource($this->centro),
            'jugadores' => JugadorResource::collection($this->jugadores),
        ];
    }
}
