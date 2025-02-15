<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  schema="Jugador",
 *  type="object",
 *  title="Jugador",
 *  required={"nombre","equipo_id"},
 *  @OA\Property(property="nombre", type="string", example="Álvaro"),
 *  @OA\Property(property="apellido1", type="string", example="Ruiz"),
 *  @OA\Property(property="apellido2", type="string", example="Gutierrez"),
 *  @OA\Property(property="tipo", type="string", example="jugador/capitan/entrenador"),
 *  @OA\Property(property="dni", type="string", example="12345678A"),
 *  @OA\Property(property="email", type="string", example="example@exa.com"),
 *  @OA\Property(property="telefono", type="string", example="+34 666 666 666"),
 *  @OA\Property(property="goles", type="intenger", example=1),
 *  @OA\Property(property="asistencias", type="integer", example=1),
 *  @OA\Property(property="tarjetas_amarillas", type="integer", example=1),
 *  @OA\Property(property="tarjetas_rojas", type="integer", example=1),
 *  @OA\Property(property="lesiones", type="integer", example=1),
 *  @OA\Property(property="equipo_nombre", type="string", example="Equipo Example"),
 *  @OA\Property(property="estudios", type="object", ref="#/components/schemas/Estudio")
 *  )
 */
class Jugador extends Model
{
    protected $table = 'jugadores';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'tipo',
        'dni',
        'email',
        'telefono',
        'goles',
        'asistencias',
        'tarjetas_amarillas',
        'tarjetas_rojas',
        'lesiones',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipo_id',
        'estudio_id'
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

    public function estudio()
    {
        return $this->belongsTo(Estudio::class);
    }

    public function actas()
    {
        return $this->hasMany(Acta::class);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}
