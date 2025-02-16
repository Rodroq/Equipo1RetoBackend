<?php

namespace Database\Seeders;

use App\Models\Jugador;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jugadores_equipos = [
            [
                [
                    'nombre' => 'Samuel',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Laura',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Raúl',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Antonio',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Javier',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Pedro',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Juan',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
                [
                    'nombre' => 'Joset Camilo',
                    'tipo' => 'jugador',
                    'equipo_id' => 1,
                    'estudio_id' =>  4
                ],
            ],
            [
                [
                    'nombre' => 'Miguel',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Pablo',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'José',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Cristina',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Juan Carlos',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Antonio',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Fernando',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Raúl',
                    'tipo' => 'jugador',
                    'equipo_id' => 2,
                    'estudio_id' =>  15
                ],
            ],
            [
                [
                    'nombre' => 'Luis',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'María',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Miguel',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Cristina',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Javier',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Pedro',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Raúl',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' => 8
                ],
                [
                    'nombre' => 'Sara',
                    'tipo' => 'jugador',
                    'equipo_id' => 3,
                    'estudio_id' =>  8
                ],
            ],
            [
                [
                    'nombre' => 'Carlos',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Elena',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Raquel',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Manuel',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Sandra',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Iván',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Fernando',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
                [
                    'nombre' => 'Javier',
                    'tipo' => 'jugador',
                    'equipo_id' => 4,
                    'estudio_id' =>  14
                ],
            ],
            [
                [
                    'nombre' => 'Álvaro',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Susana',
                    'tipo' => 'entrenador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Felipe',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Gabriel',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Sofía',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Javier',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Daniela',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Hugo',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Carla',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
                [
                    'nombre' => 'Enrique',
                    'tipo' => 'jugador',
                    'equipo_id' => 5,
                    'estudio_id' =>  17
                ],
            ],
            [
                [
                    'nombre' => 'Antonio',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Marta',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Carlos',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'David',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Cristina',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Ricardo',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Luis',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
                [
                    'nombre' => 'Ana',
                    'tipo' => 'jugador',
                    'equipo_id' => 6,
                    'estudio_id' =>  3
                ],
            ],
            [
                [
                    'nombre' => 'Jorge',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Nuria',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Victor',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Cristina',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'José',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Sandra',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Pedro',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
                [
                    'nombre' => 'Laura',
                    'tipo' => 'jugador',
                    'equipo_id' => 7,
                    'estudio_id' =>  8
                ],
            ],
            [
                [
                    'nombre' => 'Miguel',
                    'apellido1' => fake()->lastName,
                    'apellido2' => fake()->lastName,
                    'tipo' => 'capitan',
                    'dni' => fake()->unique()->randomNumber(8) . fake()->randomLetter,
                    'email' => fake()->email,
                    'telefono' => fake()->phoneNumber,
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
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Francisco',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Roberto',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Mario',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Jesús',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Juan De Dios',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Iván',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
                [
                    'nombre' => 'Joan Gabriel',
                    'tipo' => 'jugador',
                    'equipo_id' => 8,
                    'estudio_id' =>  15
                ],
            ],
        ];

        $id_usuario = User::first()->id;
        foreach ($jugadores_equipos as $jugadores) {
            foreach ($jugadores as $jugador) {
                Jugador::create([
                    'nombre' => $jugador['nombre'],
                    'apellido1' => $jugador['apellido1'] ?? null,
                    'apellido2' => $jugador['apellido2'] ?? null,
                    'tipo' => $jugador['tipo'] ?? null,
                    'dni' => $jugador['dni'] ?? null,
                    'email' => $jugador['email'] ?? null,
                    'telefono' => $jugador['telefono'] ?? null,
                    'usuarioIdCreacion' => $id_usuario,
                    'equipo_id' => $jugador['equipo_id'],
                    'estudio_id' => $jugador['estudio_id'],
                ]);
            }
        }
    }
}
