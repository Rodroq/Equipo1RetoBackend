<?php

namespace App\Http\Resources;

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
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'goles' => $this->goles,
            'asistencias' => $this->asistencias,
            'tarjetas_amarillas' => $this->tarjetas_amarillas,
            'tarjetas_rojas' => $this->tarjetas_rojas,
            'lesiones' => $this->lesiones,
            'equipo_nombre' => $this->equipo->nombre,
            'estudio' => new EstudioResource($this->estudio)
        ];
    }
}
