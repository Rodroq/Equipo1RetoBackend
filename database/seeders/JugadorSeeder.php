<?php

namespace Database\Seeders;

use App\Models\Jugador;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadorSeeder extends Seeder
{

    private $jugadores_equipos = [
        [
            [
                'nombre' => 'Samuel',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'José Carlos',
                'tipo' => 'entrenador',
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'David',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Laura',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Raúl',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Antonio',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Javier',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Pedro',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Juan',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
            [
                'nombre' => 'Joset Camilo',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 1,
                'estudio_id' =>  4
            ],
        ],
        [
            [
                'nombre' => 'Miguel',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Elena',
                'tipo' => 'entrenador',
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Alba',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Pablo',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'José',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Cristina',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Juan Carlos',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Antonio',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Fernando',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Raúl',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 2,
                'estudio_id' =>  15
            ],
        ],
        [
            [
                'nombre' => 'Luis',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Rosa',
                'tipo' => 'entrenador',
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Antonio',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'María',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Miguel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Cristina',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Javier',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Pedro',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Raúl',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' => 8
            ],
            [
                'nombre' => 'Sara',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 3,
                'estudio_id' =>  8
            ],
        ],
        [
            [
                'nombre' => 'Carlos',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Lucía',
                'tipo' => 'entrenador',
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'José',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Elena',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Raquel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Manuel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Sandra',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Iván',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Fernando',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
            [
                'nombre' => 'Javier',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 4,
                'estudio_id' =>  14
            ],
        ],
        [
            [
                'nombre' => 'Álvaro',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Susana',
                'tipo' => 'entrenador',
                'equipo_id' => 1,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Felipe',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Gabriel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Sofía',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Javier',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Daniela',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Hugo',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Carla',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
            [
                'nombre' => 'Enrique',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 5,
                'estudio_id' =>  17
            ],
        ],
        [
            [
                'nombre' => 'Antonio',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Paula',
                'tipo' => 'entrenador',
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Raúl',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Marta',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Carlos',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'David',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Cristina',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Ricardo',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Luis',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
            [
                'nombre' => 'Ana',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 6,
                'estudio_id' =>  3
            ],
        ],
        [
            [
                'nombre' => 'Jorge',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Rafael',
                'tipo' => 'entrenador',
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Manuel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Nuria',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Victor',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Cristina',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'José',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Sandra',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Pedro',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
            [
                'nombre' => 'Laura',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 7,
                'estudio_id' =>  8
            ],
        ],
        [
            [
                'nombre' => 'Miguel',
                'apellido1' => '',
                'apellido2' => '',
                'tipo' => 'capitan',
                'dni' => '',
                'email' => '',
                'telefono' => '',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Carlos',
                'tipo' => 'entrenador',
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Óscar',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Francisco',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Roberto',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Mario',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Jesús',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Juan De Dios',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Iván',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
            [
                'nombre' => 'Joan Gabriel',
                'tipo' => 'jugador',
                'goles' => 0,
                'asistencias' => 3,
                'tarjetas_amarillas' => 1,
                'tarjetas_rojas' => 0,
                'lesiones' => 0,
                'equipo_id' => 8,
                'estudio_id' =>  15
            ],
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;
        foreach ($this->jugadores_equipos as $jugadores) {
            foreach ($jugadores as $jugador) {
                Jugador::create([
                    'nombre' => $jugador['nombre'],
                    'apellido1' => $jugador['apellido1'] ?? null,
                    'apellido2' => $jugador['apellido2'] ?? null,
                    'tipo' => $jugador['tipo'] ?? null,
                    'dni' => $jugador['dni'] ?? null,
                    'email' => $jugador['email'] ?? null,
                    'telefono' => $jugador['telefono'] ?? null,
                    'goles' => $jugador['goles'] ?? null,
                    'asistencias' => $jugador['asistencias'] ?? null,
                    'tarjetas_amarillas' => $jugador['tarjetas_amarillas'] ?? null,
                    'tarjetas_rojas' => $jugador['tarjetas_rojas'] ?? null,
                    'lesiones' => $jugador['lesiones'] ?? null,
                    'usuarioIdCreacion' => $id_usuario,
                    'equipo_id' => $jugador['equipo_id'],
                    'estudio_id' => $jugador['estudio_id'],
                ]);
            }
        }
    }
}
