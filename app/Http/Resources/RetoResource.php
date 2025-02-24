<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class RetoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'slug' => $this->slug,
            'titulo' => $this->titulo,
            'texto' => $this->texto,
            'estudio' => new EstudioResource($this->estudio),
        ];
    }
}
