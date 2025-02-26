<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Acta;
use App\Models\Jugador;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActasSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;

        $jugadores = Jugador::get();
        $partidos = Partido::get();


        $actas = [
            ['incidencia' => 'goles', 'hora' => '12:05:00', 'comentario' => 'Golazo desde fuera del área.', 'partido_id' => $partidos->first()->id, 'jugador_id' => $jugadores->first()->id],
            ['incidencia' => 'asistencias', 'hora' => '12:10:00', 'comentario' => 'Pase preciso para el gol.', 'partido_id' => $partidos->get(2)->id, 'jugador_id' => $jugadores->get(7)->id],
            ['incidencia' => 'tarjetas_amarillas', 'hora' => '12:15:00', 'comentario' => 'Tarjeta amarilla por falta fuerte.', 'partido_id' => $partidos->get(3)->id, 'jugador_id' => $jugadores->get(14)->id],
            ['incidencia' => 'lesiones', 'hora' => '12:20:00', 'comentario' => 'Jugador lesionado tras una entrada dura.', 'partido_id' => $partidos->get(1)->id, 'jugador_id' => $jugadores->get(10)->id],
            ['incidencia' => 'goles', 'hora' => '12:25:00', 'comentario' => 'Gol de cabeza tras un córner.', 'partido_id' => $partidos->first()->id, 'jugador_id' => $jugadores->get(16)->id],
            ['incidencia' => 'asistencias', 'hora' => '12:30:00', 'comentario' => 'Asistencia con un pase filtrado.', 'partido_id' => $partidos->get(4)->id, 'jugador_id' => $jugadores->get(5)->id],
            ['incidencia' => 'tarjetas_amarillas', 'hora' => '12:35:00', 'comentario' => 'Segunda amarilla, expulsión del jugador.', 'partido_id' => $partidos->get(2)->id, 'jugador_id' => $jugadores->get(11)->id],
            ['incidencia' => 'lesiones', 'hora' => '12:40:00', 'comentario' => 'Cambio obligado por lesión muscular.', 'partido_id' => $partidos->get(3)->id, 'jugador_id' => $jugadores->get(8)->id],
            ['incidencia' => 'goles', 'hora' => '12:45:00', 'comentario' => 'Golazo de tiro libre.', 'partido_id' => $partidos->get(1)->id, 'jugador_id' => $jugadores->get(13)->id],
            ['incidencia' => 'asistencias', 'hora' => '12:50:00', 'comentario' => 'Pase largo que deja solo al delantero.', 'partido_id' => $partidos->get(4)->id, 'jugador_id' => $jugadores->get(9)->id],
            ['incidencia' => 'tarjetas_amarillas', 'hora' => '12:55:00', 'comentario' => 'Falta en el área, penal y amarilla.', 'partido_id' => $partidos->get(2)->id, 'jugador_id' => $jugadores->get(18)->id],
            ['incidencia' => 'lesiones', 'hora' => '13:00:00', 'comentario' => 'Golpe fuerte, necesita asistencia médica.', 'partido_id' => $partidos->get(1)->id, 'jugador_id' => $jugadores->get(6)->id],
            ['incidencia' => 'goles', 'hora' => '13:05:00', 'comentario' => 'Definición exquisita en el mano a mano.', 'partido_id' => $partidos->get(3)->id, 'jugador_id' => $jugadores->get(12)->id],
            ['incidencia' => 'asistencias', 'hora' => '13:10:00', 'comentario' => 'Pase con el exterior, asistencia magistral.', 'partido_id' => $partidos->get(4)->id, 'jugador_id' => $jugadores->get(17)->id],
            ['incidencia' => 'tarjetas_rojas', 'hora' => '13:15:00', 'comentario' => 'Tarjeta roja por entrada peligrosa.', 'partido_id' => $partidos->get(1)->id, 'jugador_id' => $jugadores->get(15)->id],
            ['incidencia' => 'goles', 'hora' => '13:30:00', 'comentario' => 'Gol de penalti.', 'partido_id' => $partidos->first()->id, 'jugador_id' => $jugadores->get(77)->id],
            ['incidencia' => 'goles', 'hora' => '13:45:00', 'comentario' => 'Gol de penalti.', 'partido_id' => $partidos->first()->id, 'jugador_id' => $jugadores->get(69)->id],
        ];

        foreach ($actas as $acta) {
            Acta::create([
                'incidencia' => $acta['incidencia'],
                'hora' => $acta['hora'],
                'comentario' => $acta['comentario'],
                'usuarioIdCreacion' => $id_usuario,
                'partido_id' => $acta['partido_id'],
                'jugador_id' => $acta['jugador_id'],
            ]);
        }
    }
}
