<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Publicacion extends Model
{
    use HasSlug;

    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'texto',
        'portada',
        'rutavideo',
        'rutaaudio',
        'equipo_id',
        'partido_id',
        'patrocinador_id',
        'jugador_id',
        'reto_id',
        'ong_id',
        'pabellon_id',
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

    public function retos()
    {
        return $this->belongsTo(Reto::class);
    }

    public function patrocinadores()
    {
        return $this->belongsTo(Patrocinador::class);
    }

    public function equipos()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function jugadores()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function partidos()
    {
        return $this->belongsTo(Partido::class);
    }
}
