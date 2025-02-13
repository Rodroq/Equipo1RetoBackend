<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Equipo",
 *     type="object",
 *     required={"id", "nombre", "jugadores"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Desguace FC"),
 *     @OA\Property(property="grupo", type="string", example="A"),
 *     @OA\Property(property="centro_id", type="string", example="IES Zapatón"),
 *     @OA\Property(
 *         property="jugadores",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Jugador")
 *     )
 * )
 */
class Equipo extends Model
{
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

    /*
        Descomentar una vez se quieran hacer pruebas con las inserciones de grupos de usuarios autenticados
        protected static function boot(){
            parent::boot();

            static::creating(function($model){
                $model->usuarioIdCreacion = auth()->id();
                $model->fechaCreacion = now();
            });

            static::updating(function($model){
                $model->usuarioIdActualizacion = auth()->id();
                $model->fechaActualizacion = now();
            });
        }
    */

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

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }

    public function patrocinadores()
    {
        return $this->belongsToMany(Patrocinador::class);
    }

    public function centros()
    {
        return $this->belongsTo(Centro::class);
    }
}
