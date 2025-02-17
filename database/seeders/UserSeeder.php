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
        $david = User::create([
            'name' => 'David',
            'email' => 'minillanillo@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $david->assignRole('coach');

        //usuario director de torneo
        $rodrigo = User::create([
            'name' => 'Rodrido',
            'email' => 'rodri@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $rodrigo->assignRole('director');

        //usuario periodista
        $alvaro = User::create([
            'name' => 'Álvaro',
            'email' => 'alvaro@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $alvaro->assignRole('reporter');

        //usuario administrador
        $pablo = User::create([
            'name' => 'Pablo',
            'email' => 'pablo@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $pablo->assignRole('administrator');
    }
}
