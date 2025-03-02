<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function jugadores()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function partidos()
    {
        return $this->belongsTo(Partido::class);
    }
}
