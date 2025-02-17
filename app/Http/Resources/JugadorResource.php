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
        $estadisticas = EstadisticasJugador::where('jugador_id', $this->id)->first();
        return [
            'nombre' => $this->nombre,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'tipo' => $this->tipo,
            'dni' => $this->dni,
            'email' => $this->email,
            'telefono' => $this->telefono,
            // Hace falta el 0?
            'estadisticas' => [
                'goles' => $estadisticas->goles ?? 0,
                'asistencias' => $estadisticas->asistencias ?? 0,
                'tarjetas_amarillas' => $estadisticas->tarjetas ?? 0,
                'tarjetas_rojas' => $estadisticas->tarjetas ?? 0,
                'lesiones' => $estadisticas->lesiones ?? 0,
            ],
            'estudio' => new EstudioResource($this->estudio)
        ];
    }
}
