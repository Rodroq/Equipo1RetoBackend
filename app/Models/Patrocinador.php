<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 *  schema="Patrocinador",
 *  type="object",
 *  title="Patrocinador",
 *  required={"nombre","slug", "equipo"},
 *  @OA\Property(property="nombre", type="string", example="Desguace FC"),
 *  @OA\Property(property="slug", type="string"),
 *  @OA\Property(property="equipo", type="string", example="desguace-fc"),
 *  @OA\Property(property="imagenes", type="object",
 *      @OA\Property(property="url", type="string"),
 *      @OA\Property(property="nombre", type="string", example="1-nombre")
 *  ),
 * )
 */
class Patrocinador extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'patrocinadores';

    protected $fillable = [
        'nombre',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion'
    ];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
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
        $this->addMediaCollection('patrocinador_imagenes')
            ->useDisk('images_tournament')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg']);
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

    public function publicaciones(): MorphMany
    {
        return $this->morphMany(Publicacion::class, 'publicacionable')->chaperone('patrocinador');
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class,'patrocinadores_equipos');
    }
}
