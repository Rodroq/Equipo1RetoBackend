<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    protected $table = 'estudios';

    public function centros(){
        return $this->belongsTo(Centro::class);
    }

    public function jugadores(){
        return $this->hasMany(Jugador::class);
    }

}
