<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function estudios()
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

    public function equipos()
    {
        return $this->belongsTo(Equipo::class);
    }
}
