<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{

    private $equipos = [
        ['id' => 1, 'nombre' => 'Desguace FC', 'grupo' => 'A', 'centro_id' => 4],
        ['id' => 2, 'nombre' => 'Yayo Vallecano', 'grupo' => 'A', 'centro_id' => 5],
        ['id' => 3, 'nombre' => 'Mag-nificos', 'grupo' => 'A', 'centro_id' => 6],
        ['id' => 4, 'nombre' => 'Imperio ASIR', 'grupo' => 'A', 'centro_id' => 7],
        ['id' => 5, 'nombre' => 'Volt Damm 01', 'grupo' => 'B', 'centro_id' => 8],
        ['id' => 6, 'nombre' => 'Niños de papi 02', 'grupo' => 'B', 'centro_id' => 9],
        ['id' => 7, 'nombre' => 'Chatgepeteros', 'grupo' => 'B', 'centro_id' => 10],
        ['id' => 8, 'nombre' => 'Chatarreros FC', 'grupo' => 'B', 'centro_id' => 11],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;
        foreach ($this->equipos as $equipo) {
            Equipo::create([
                'id'=>$equipo['id'],
                'nombre' => $equipo['nombre'],
                'grupo' => $equipo['grupo'],
                'centro_id' => $equipo['centro_id'],
                'usuarioIdCreacion' => $id_usuario,
            ]);
        }
    }
}
