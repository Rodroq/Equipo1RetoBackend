<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Reto",
 *     type="object",
 *     required={"id", "titulo", "texto"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="titulo", type="string", example="Desafío de programación"),
 *     @OA\Property(property="texto", type="string", example="Completa los ejercicios en el menor tiempo posible"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-13T14:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-14T18:30:00Z")
 * )
 */
class Reto extends Model
{
    protected $table = 'retos';


    public function publicaciones(){
        return $this->hasMany(Publicacion::class);
    }

    public function estudios(){
        return $this->belongsTo(Estudio::class);
    }

    public function imagenes() {
        return $this->hasMany(Imagen::class);
    }
}
