<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 *     schema="Reto",
 *     type="object",
 *     required={"id", "titulo", "texto"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="titulo", type="string", example="Merchandising de la Liga"),
 *     @OA\Property(property="texto", type="string", example="Desde de la familia profesional de Textil, Confección y Piel el IES Besaya a través de su ciclo Profesional Básico en Tapicería y Cortinaje ha diseñado el RETO de Merchadising. Este RETO tiene la finalidad de diseñar y confeccionan productos de merchandising como chapas, llaveros, gorras con los logos de la Liga, centros participantes y diseños exclusivos para la venta y recaudación de fondos destinados a nuestra ONG. La venta se realizará en el propio reciento del evento durante los días 12 y 13 de marzo. Para ello se instalará una expositor tienda dentro del propio recinto."),
 *     @OA\Property(property="estudio", type="object", ref="#/components/schemas/Estudio"),
 * )
 */
class Reto extends Model
{
    use HasSlug;

    protected $table = 'retos';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('titulo')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function estudio()
    {
        return $this->belongsTo(Estudio::class);
    }
}
