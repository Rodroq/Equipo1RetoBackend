<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 * schema="Partido",
 * type="object",
 * title="Partido",
 * required={"fecha", "hora", "equipoLoc", "golesVis", "pabellon"},
 * @OA\Property(property="slug", type="string", example="partido"),
 * @OA\Property(property="fecha", type="string", example="2021-10-10"),
 * @OA\Property(property="hora", type="string", format="time", example="16:00:00"),
 * @OA\Property(property="equipoLoc", type="integer", example=1),
 * @OA\Property(property="equipoVis", type="integer", example=2),
 * )
 */
class Partido extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'partidos';

    protected $fillable = [
        'id',
        'fecha',
        'hora',
        'golesL',
        'golesV',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipoL',
        'equipoV',
        'pabellon_id'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(fn() => 'partido')
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('partido_imagenes')
            ->useDisk('images_tournament')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg']);
    }

    public function actas()
    {
        return $this->hasMany(Acta::class);
    }

    public function equipoLoc()
    {
        return $this->belongsTo(Equipo::class, 'equipoL');
    }

    public function equipoVis()
    {
        return $this->belongsTo(Equipo::class, 'equipoV');
    }

    public function publicaciones(): MorphMany
    {
        return $this->morphMany(Publicacion::class, 'publicacionable')->chaperone('partido');
    }

    public function pabellon()
    {
        return $this->belongsTo(Pabellon::class);
    }
}
