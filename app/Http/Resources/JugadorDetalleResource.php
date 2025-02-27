<?php

namespace App\Http\Resources;

use App\Models\EstadisticasJugador;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JugadorDetalleResource extends JsonResource
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
            'estadisticas' => [
                'goles' => intval($estadisticas->goles),
                'asistencias' => intval($estadisticas->asistencias),
                'tarjetas_amarillas' => intval($estadisticas->tarjetas_amarillas),
                'tarjetas_rojas' => intval($estadisticas->tarjetas_rojas),
                'lesiones' => intval($estadisticas->lesiones ),
            ],
            'estudio' => new EstudioResource($this->estudio),
            'equipo' => $this->equipo->nombre,
            'imagenes' => ImagenResource::collection($this->getMedia())
        ];
    }
}
