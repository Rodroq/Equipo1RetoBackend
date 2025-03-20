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
            'slug' => $this->slug,
            'nombre' => $this->nombre,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'tipo' => $this->tipo,
            'estadisticas' => [
                'goles' => intval($estadisticas->goles ?? 0),
                'asistencias' => intval($estadisticas->asistencias ?? 0),
                'tarjetas_amarillas' => intval($estadisticas->tarjetas_amarillas ?? 0),
                'tarjetas_rojas' => intval($estadisticas->tarjetas_rojas ?? 0),
                'lesiones' => intval($estadisticas->lesiones ?? 0),
            ],
            'estudio' => new EstudioResource($this->estudio),
            'equipo' => $this->equipo->nombre,
            'imagenes' => MediaResource::collection($this->getMedia())
        ];
    }
}
