<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Acta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActasSeeder extends Seeder
{

    private $actas = [
        ['id' => 1, 'incidencia' => 'goles', 'hora' => '12:05:00', 'comentario' => 'Golazo desde fuera del área.', 'partido_id' => 1, 'jugador_id' => 1],
        ['id' => 2, 'incidencia' => 'asistencias', 'hora' => '12:10:00', 'comentario' => 'Pase preciso para el gol.', 'partido_id' => 3, 'jugador_id' => 8],
        ['id' => 3, 'incidencia' => 'tarjetas', 'hora' => '12:15:00', 'comentario' => 'Tarjeta amarilla por falta fuerte.', 'partido_id' => 4, 'jugador_id' => 15],
        ['id' => 4, 'incidencia' => 'lesiones', 'hora' => '12:20:00', 'comentario' => 'Jugador lesionado tras una entrada dura.', 'partido_id' => 2, 'jugador_id' => 11],
        ['id' => 5, 'incidencia' => 'goles', 'hora' => '12:25:00', 'comentario' => 'Gol de cabeza tras un córner.', 'partido_id' => 1, 'jugador_id' => 17],
        ['id' => 6, 'incidencia' => 'asistencias', 'hora' => '12:30:00', 'comentario' => 'Asistencia con un pase filtrado.', 'partido_id' => 5, 'jugador_id' => 6],
        ['id' => 7, 'incidencia' => 'tarjetas', 'hora' => '12:35:00', 'comentario' => 'Segunda amarilla, expulsión del jugador.', 'partido_id' => 3, 'jugador_id' => 12],
        ['id' => 8, 'incidencia' => 'lesiones', 'hora' => '12:40:00', 'comentario' => 'Cambio obligado por lesión muscular.', 'partido_id' => 4, 'jugador_id' => 9],
        ['id' => 9, 'incidencia' => 'goles', 'hora' => '12:45:00', 'comentario' => 'Golazo de tiro libre.', 'partido_id' => 2, 'jugador_id' => 14],
        ['id' => 10, 'incidencia' => 'asistencias', 'hora' => '12:50:00', 'comentario' => 'Pase largo que deja solo al delantero.', 'partido_id' => 5, 'jugador_id' => 10],
        ['id' => 11, 'incidencia' => 'tarjetas', 'hora' => '12:55:00', 'comentario' => 'Falta en el área, penal y amarilla.', 'partido_id' => 3, 'jugador_id' => 19],
        ['id' => 12, 'incidencia' => 'lesiones', 'hora' => '13:00:00', 'comentario' => 'Golpe fuerte, necesita asistencia médica.', 'partido_id' => 1, 'jugador_id' => 7],
        ['id' => 13, 'incidencia' => 'goles', 'hora' => '13:05:00', 'comentario' => 'Definición exquisita en el mano a mano.', 'partido_id' => 4, 'jugador_id' => 13],
        ['id' => 14, 'incidencia' => 'asistencias', 'hora' => '13:10:00', 'comentario' => 'Pase con el exterior, asistencia magistral.', 'partido_id' => 5, 'jugador_id' => 18],
        ['id' => 15, 'incidencia' => 'tarjetas', 'hora' => '13:15:00', 'comentario' => 'Tarjeta roja por entrada peligrosa.', 'partido_id' => 2, 'jugador_id' => 16],
        ['id' => 16, 'incidencia' => 'goles', 'hora' => '13:30:00','comentario' => 'Gol de penalti.', 'partido_id' => 1, 'jugador_id' => 78],
        ['id' => 17, 'incidencia' => 'goles', 'hora' => '13:45:00','comentario' => 'Gol de penalti.', 'partido_id' => 1, 'jugador_id' => 70],
    ];
    
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;
        foreach($this->actas as $acta){
            Acta::create([
                'id' => $acta['id'],
                'incidencia' => $acta['incidencia'],
                'hora' => $acta['hora'],
                'comentario' => $acta['comentario'],
                'usuarioIdCreacion' => $id_usuario,
                'partido_id' => $acta['partido_id'],
                'jugador_id'=> $acta['jugador_id'],
            ]);
        }       
    }
}
