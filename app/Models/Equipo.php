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
 *  schema="Equipo",
 *  type="object",
 *  title="Equipo",
 *  required={"nombre", "jugadores"},
 *  @OA\Property(property="nombre", type="string", example="Desguace FC"),
 *  @OA\Property(property="slug", type="string", example="desguace-fc"),
 *  @OA\Property(property="grupo", type="string", example="A"),
 *  @OA\Property(property="centro", type="object", ref="#/components/schemas/Centro"),
 *  @OA\Property(property="jugadores", type="array",
 *      @OA\Items(
 *              @OA\Property(property="slug", type="string"),
 *              @OA\Property(property="nombre", type="string", example="Nombre"),
 *              @OA\Property(property="apellido1", type="string", example="Apellido 1"),
 *              @OA\Property(property="apellido2", type="string", example="apellido 2"),
 *              @OA\Property(property="tipo", type="string", example="[jugador|capitan|entrenador]"),
 *              @OA\Property(property="imagen", type="object",
 *              @OA\Property(property="url", type="string"),
 *              @OA\Property(property="nombre", type="string", example="1-nombre")
 *          ),
 *      )
 *  ),
 *  @OA\Property(property="imagenes", type="object",
 *      @OA\Property(property="url", type="string"),
 *      @OA\Property(property="nombre", type="string", example="1-nombre")
 *  ),
 * )
 */
class Equipo extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $table = 'equipos';

    protected $fillable = [
        'nombre',
        'grupo',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'centro_id'
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
        $this->addMediaCollection('equipo_imagenes')
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

    /**
     * Crea múltiples jugadores relacionados con el equipo.
     *
     * @param array $jugadores Un array de datos de jugadores (pueden ser arrays con los campos necesarios para crear un Jugador).
     * @return void
     */
    public function crearJugadores($jugadores)
    {
        $this->jugadores()->createMany(
            collect($jugadores)->map(function ($jugador) {
                if (!array_key_exists('ciclo', $jugador)) {
                    return $jugador;
                }

                $ciclo_id = Ciclo::where('nombre', $jugador['ciclo'])->first()->id;
                $estudio_id = Estudio::where('ciclo_id', $ciclo_id)->first()->id;
                $jugador['estudio_id'] = $estudio_id;

                return $jugador;
            })
        );
    }

    public function partidos()
    {
        return $this->hasMany(Partido::class, 'equipoL')
            ->orWhere('equipoV');
    }

    public function inscripciones()
    {
        return $this->hasOne(Inscripcion::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function publicaciones(): MorphMany
    {
        return $this->morphMany(Publicacion::class, 'publicacionable')->chaperone('equipo');
    }

    public function patrocinadores()
    {
        return $this->belongsToMany(Patrocinador::class,'patrocinadores_equipos');
    }

    public function centro()
    {
        return $this->belongsTo(Centro::class);
    }
}
