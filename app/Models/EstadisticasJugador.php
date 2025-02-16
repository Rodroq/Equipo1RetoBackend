<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadisticasJugador extends Model
{
    protected $table = 'estadisticas_jugadores_view';

    protected $primarykey = 'jugador_id';

    protected $guarded = [];

    /* protected $fillable = [
        'jugador_id',
        'nombre',
        'apellido1',
        'apellido2',
        'goles',
        'asistencias',
        'tarjetas',
        'lesiones'
    ]; */
}
