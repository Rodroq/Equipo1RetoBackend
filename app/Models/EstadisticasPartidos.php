<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticasPartidos extends Model
{
    protected $table = "estadisticas_partidos";

    protected $primarykey = 'partido_id';

    protected $fillable = [
        'partido_id',
        'fecha',
        'equipo_local',
        'equipo_visitante',
        'goles_local',
        'goles_visitante',
    ];
}
