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
 *  schema="Jugador",
 *  type="object",
 *  title="Jugador",
 *  required={"nombre"},
 *  @OA\Property(property="nombre", type="string", example="Álvaro"),
 *  @OA\Property(property="apellido1", type="string", example="Ruiz"),
 *  @OA\Property(property="apellido2", type="string", example="Gutierrez"),
 *  @OA\Property(property="slug", type="string", example="alvaro-ruiz-gutierrez"),
 *  @OA\Property(property="tipo", type="string", example="[jugador|capitan|entrenador]"),
 *  @OA\Property(property="dni", type="string", example="12345678A"),
 *  @OA\Property(property="email", type="string", example="example@exa.com"),
 *  @OA\Property(property="telefono", type="string", example="+34 666 666 666"),
 *  @OA\Property(property="estadisticas", type="object",
 *      @OA\Property(property="goles", type="integer", example=1),
 *      @OA\Property(property="asistencias", type="integer", example=1),
 *      @OA\Property(property="tarjetas_amarillas", type="integer", example=1),
 *      @OA\Property(property="tarjetas_rojas", type="integer", example=1),
 *      @OA\Property(property="lesiones", type="integer", example=1),
 *  ),
 *  @OA\Property(property="estudios", type="object", ref="#/components/schemas/Estudio"),
 *  @OA\Property(property="imagenes", type="object",
 *      @OA\Property(property="url", type="string"),
 *      @OA\Property(property="nombre", type="string", example="1-nombre")
 *  ),
 * )
 */
class Jugador extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;
    protected $table = 'jugadores';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'tipo',
        'dni',
        'email',
        'telefono',
        'equipo_id',
        'estudio_id',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['nombre', 'apellido1', 'apellido2'])
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
        $this->addMediaCollection('jugador_imagenes')
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

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function estudio()
    {
        return $this->belongsTo(Estudio::class);
    }

    public function actas()
    {
        return $this->hasMany(Acta::class);
    }

    public function publicaciones(): MorphMany
    {
        return $this->morphMany(Publicacion::class, 'publicacionable')->chaperone('jugador');
    }
}
