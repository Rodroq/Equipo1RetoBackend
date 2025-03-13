<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 *  schema="Acta",
 *  type="object",
 *  title="Acta",
 *  @OA\Property(property="incidencia", type="string"),
 *  @OA\Property(property="slug", type="string", example="desguace-fc"),
 *  @OA\Property(property="hora", type="string", example="13:30:20"),
 *  @OA\Property(property="comentario", type="string"),
 * )
 */
class Acta extends Model
{
    use HasSlug;

    protected $table = 'actas';

    protected $fillable = [
        'slug',
        'incidencia',
        'hora',
        'comentario',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'partido_id',
        'jugador_id',
        'fechaActualizacion'
    ];

    public function getSlugOptions(): SlugOptions
    {
        $nombre_jugador = $this->jugador->nombre;
        $partido = $this->partido->slug;

        $slug = "{$nombre_jugador}-{$this->incidencia}-en-{$partido}";

        return SlugOptions::create()
            ->generateSlugsFrom(fn() => $slug)
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

     protected static function boot()
     {
         parent::boot();

         static::creating(function ($model) {
             $model->usuarioIdCreacion = Auth::user()->id;
             $model->fechaCreacion = now();
         });

         static::updating(function ($model) {
             $model->usuarioIdActualizacion = Auth::user()->id;
             $model->fechaActualizacion = now();
         });
     }

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }
}
