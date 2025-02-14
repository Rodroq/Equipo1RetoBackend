<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $table = 'partidos';

    protected $fillable = [
        'fecha',
        'hora',
        'golesL',
        'golesV',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'fechaActualizacion',
        'equipoL',
        'equipoV',
        'pabellon_id'

    ];

    // protected static function boot(){
    //     parent::boot();

    //     static::creating(function($model){
    //         $model->usuarioIdCreacion = auth()->id();
    //         $model->fechaCreacion = now();
    //     });
        
    //     static::updating(function($model){
    //         $model->usuarioIdActualizacion = auth()->id();
    //         $model->fechaActualizacion = now();
    //     });
    // }

    public function actas(){
        return $this->hasMany(Acta::class);
    }

    public function equipos(){
        //Cada belongsTo devuelve un id de equipo por eso los junto
        return $this->belongsTo(Equipo::class,'equipoL')->get()->merge($this->belongsTo(Equipo::class,'equipoV')->get());
    }

    public function imagenes(){
        return $this->hasMany(Imagen::class);
    }

    public function publicaciones(){
        return $this->hasMany(Publicacion::class);
    }
}
