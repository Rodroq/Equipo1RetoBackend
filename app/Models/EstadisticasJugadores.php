<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticasJugadores extends Model
{
    protected $table = 'estadisticas_jugadores';

    protected $primarykey = 'jugador_id';

    protected $fillable = [
        'jugador_id',
        'nombre',
        'apellido1',
        'apellido2',
        'goles',
        'asistencias',
        'tarjetas',
        'lesiones'
    ];
}
