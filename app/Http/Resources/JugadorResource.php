<?php

namespace App\Http\Resources;

use App\Models\EstadisticasJugador;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JugadorResource extends JsonResource
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
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'tipo' => $this->tipo,
        ];
    }
}
