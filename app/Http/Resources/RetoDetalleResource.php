<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RetoDetalleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'titulo' => $this->titulo,
            'texto' => $this->texto,
            'estudio' => new EstudioResource($this->estudio),
            'imagenes' => ImagenResource::collection($this->getMedia()),
        ];
    }
}
