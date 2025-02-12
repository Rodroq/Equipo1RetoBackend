<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reto extends Model
{
    protected $table = 'retos';


    public function publicaciones(){
        return $this->hasMany(Publicacion::class);
    }

    public function estudios(){
        return $this->belongsTo(Estudio::class);
    }

    public function imagenes() {
        return $this->hasMany(Imagen::class);
    }
}
