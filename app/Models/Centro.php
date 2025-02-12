<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = 'centros';


    public function equipos(){
        return $this->hasMany(Equipo::class);
    }

    public function estudios(){
        return $this->hasMany(Estudio::class);
    }
}
