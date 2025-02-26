<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    protected $table = 'actas';

    protected $fillable = [
        'incidencia',
        'hora',
        'comentario',
        'usuarioIdCreacion',
        'fechaCreacion',
        'usuarioIdActualizacion',
        'partido_id',
        'jugador_id',
        'fechaActualizacion'
    ];
    //Descomentar una vez se quieran hacer pruebas con las inserciones de grupos de usuarios autenticados
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

    public function jugadores(){
        return $this->belongsTo(Jugador::class);
    }

    public function partidos(){
        return $this->belongsTo(Partido::class);
    }
}
