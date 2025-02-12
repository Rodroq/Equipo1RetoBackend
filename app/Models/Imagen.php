<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'url',
        'nombre',
        'equipo_id',
        'partido_id',
        'patrocinador_id',
        'jugador_id',
        'reto_id',
        'ong_id',
        'publicacion_id',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion'
    ];

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

    public function partidos() {
        return $this->belongsTo(Partido::class);
    }

    public function publicaciones() {
        return $this->belongsTo(Publicacion::class);
    }

    public function patrocinadores() {
        return $this->belongsTo(Patrocinador::class);
    }

    public function retos() {
        return  $this->belongsTo(Reto::class);
    }

    public function equipos() {
        return $this->belongsTo(Equipo::class);
    }

    public function jugadores() {
        return $this->belongsTo(Jugador::class);
    }
}
