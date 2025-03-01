<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 *  schema="Publicacion",
 *  type="object",
 *  title="Publicacion",
 *  @OA\Property(property="titulo", type="string", example="Titulo"),
 *  @OA\Property(property="slug", type="string", example="titulo"),
 *  @OA\Property(property="texto", type="string"),
 *  @OA\Property(property="portada", type="boolean"),
 *  @OA\Property(property="rutaaudio", type="string"),
 *  @OA\Property(property="rutavideo", type="string"),
 *  @OA\Property(property="imagenes", type="object",
 *      @OA\Property(property="url", type="string"),
 *      @OA\Property(property="nombre", type="string", example="1-nombre")
 *  ),
 * )
 */
class Publicacion extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'texto',
        'portada',
        'rutavideo',
        'rutaaudio',
        'publicacionable_type',
        'publicacionable_id',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('publicacion_imagenes')
            ->useDisk('images_tournament')
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

    public function publicacionable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'publicacionable_type', 'publicacionable_id');
    }
}
