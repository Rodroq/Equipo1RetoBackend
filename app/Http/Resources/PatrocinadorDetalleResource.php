<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatrocinadorDetalleResource extends JsonResource
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
            'equipo' => $this->equipos()->first()->slug,
            'imagenes' => MediaResource::collection($this->getMedia())
        ];
    }
}
