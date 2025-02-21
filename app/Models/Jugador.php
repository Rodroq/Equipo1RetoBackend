<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *  schema="Jugador",
 *  type="object",
 *  title="Jugador",
 *  required={"nombre"},
 *  @OA\Property(property="nombre", type="string", example="Álvaro"),
 *  @OA\Property(property="apellido1", type="string", example="Ruiz"),
 *  @OA\Property(property="apellido2", type="string", example="Gutierrez"),
 *  @OA\Property(property="tipo", type="string", example="[jugador|capitan|entrenador]"),
 *  @OA\Property(property="dni", type="string", example="12345678A"),
 *  @OA\Property(property="email", type="string", example="example@exa.com"),
 *  @OA\Property(property="telefono", type="string", example="+34 666 666 666"),
 *  @OA\Property(property="goles", type="intenger", example=1),
 *  @OA\Property(property="asistencias", type="integer", example=1),
 *  @OA\Property(property="tarjetas_amarillas", type="integer", example=1),
 *  @OA\Property(property="tarjetas_rojas", type="integer", example=1),
 *  @OA\Property(property="lesiones", type="integer", example=1),
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
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipo_id',
        'estudio_id'
    ];

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

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
}
