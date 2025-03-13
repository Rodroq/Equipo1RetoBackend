<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @OA\Schema(
 *  schema="Inscripcion",
 *  type="object",
 *  title="Inscripcion",
 *  @OA\Property(property="slug", type="string", example="desguace-fc"),
 *  @OA\Property(property="comentarion", type="string"),
 *  @OA\Property(property="estado", type="string", example="[pendiente | rechazada | aprobada]"),
 *  @OA\Property(property="equipo", type="string", example="Equipo"),
 * )
 */
class Inscripcion extends Model
{
    use HasSlug;

    protected $table = 'inscripciones';

    protected $fillable = [
        'comentarios',
        'estado',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipo_id'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->usuarioIdCreacion = Auth::user()->id;
    //         $model->fechaCreacion = now();
    //     });

    //     static::updating(function ($model) {
    //         $model->usuarioIdActualizacion = Auth::user()->id;
    //         $model->fechaActualizacion = now();
    //     });
    // }

    public function getSlugOptions(): SlugOptions
    {
        $equipo = $this->equipo->nombre;

        return SlugOptions::create()
            ->generateSlugsFrom(fn() => $equipo)
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

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}
