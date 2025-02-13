<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'nombre' => $this->nombre,
            'grupo' => $this->grupo,
            'centro_id' => $this->centro_id,
            'jugadores' => JugadorResource::collection(Jugador::all()),
        ];
    }
}
