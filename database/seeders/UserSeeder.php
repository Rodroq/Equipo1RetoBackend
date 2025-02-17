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
        //usuario entrenador
        $entrenador = User::create([
            'name' => 'Entrenador',
            'email' => 'minillanillo@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $entrenador->assignRole('entrenador');

        //usuario director de torneo
        $director = User::create([
            'name' => 'Director',
            'email' => 'rodri@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $director->assignRole('director');

        //usuario periodista
        $periodista = User::create([
            'name' => 'Periodista',
            'email' => 'alvaro@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $periodista->assignRole('periodista');

        //usuario administrador
        $administrador = User::create([
            'name' => 'Administrador',
            'email' => 'pablo@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $administrador->assignRole('administrador');
    }
}
