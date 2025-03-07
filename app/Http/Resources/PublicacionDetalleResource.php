<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicacionDetalleResource extends JsonResource
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
            'slug' => $this->slug,
            'texto' => $this->texto,
            'tipo' => $this->publicacionable_type,
            'portada' => $this->portada,
            'rutaaudio' => $this->rutaaudio,
            'rutavideo' => $this->rutavideo,
            'imagenes' => MediaResource::collection($this->getMedia())
        ];
    }
}
