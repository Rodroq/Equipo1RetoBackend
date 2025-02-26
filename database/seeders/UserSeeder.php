<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //usuarios entrenador
        $entrenador1 = User::create([
            'name' => 'Entrenador',
            'email' => 'entrena1@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $entrenador2 = User::create([
            'name' => 'Entrenador2',
            'email' => 'entrena2@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $entrenador1->assignRole('entrenador');
        $entrenador2->assignRole('entrenador');

        //usuario director de torneo
        $director = User::create([
            'name' => 'Director',
            'email' => 'director@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $director->assignRole('director');

        //usuario periodista
        $periodista = User::create([
            'name' => 'Periodista',
            'email' => 'periodista@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $periodista->assignRole('periodista');

        //usuario administrador
        $administrador = User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $administrador->assignRole('administrador');
    }
}
