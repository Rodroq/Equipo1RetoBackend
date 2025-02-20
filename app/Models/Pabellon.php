<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pabellon extends Model
{
    protected $table = 'pabellones';

    public function partido(){
        return $this->hasMany(Partido::class);
    }
}
