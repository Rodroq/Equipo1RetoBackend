<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
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

    public function retos() {
        return $this->belongsTo(Reto::class);
    }

    public function patrocinadores() {
        return $this->belongsTo(Patrocinador::class);
    }

    public function equipos() {
        return $this->belongsTo(Equipo::class);
    }

    public function jugadores() {
        return $this->belongsTo(Jugador::class);
    }

    public function partidos() {
        return $this->belongsTo(Partido::class);
    }

    public function imagenes() {
        return $this->hasMany(Imagen::class);
    }
}
