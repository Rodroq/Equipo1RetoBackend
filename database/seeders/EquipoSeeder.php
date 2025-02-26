<?php

namespace Database\Seeders;

use App\Models\Centro;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;

        $centros = Centro::get();

        $centro_first = $centros->first();
        $centro_second = $centros->get(1);
        $centro_last = $centros->last();
        $equipos = [
            ['id' => 1, 'nombre' => 'Desguace FC', 'grupo' => 'A', 'centro_id' => $centro_first->id],
            ['id' => 2, 'nombre' => 'Yayo Vallecano', 'grupo' => 'A', 'centro_id' => $centro_first->id],
            ['id' => 3, 'nombre' => 'Mag-nificos', 'grupo' => 'A', 'centro_id' => $centro_first->id],
            ['id' => 4, 'nombre' => 'Imperio ASIR', 'grupo' => 'A', 'centro_id' => $centro_second->id],
            ['id' => 5, 'nombre' => 'Volt Damm 01', 'grupo' => 'B', 'centro_id' => $centro_second->id],
            ['id' => 6, 'nombre' => 'Niños de papi 02', 'grupo' => 'B', 'centro_id' => $centro_second->id],
            ['id' => 7, 'nombre' => 'Chatgepeteros', 'grupo' => 'B', 'centro_id' => $centro_last->id],
            ['id' => 8, 'nombre' => 'Chatarreros FC', 'grupo' => 'B', 'centro_id' => $centro_last->id],
        ];
        foreach ($equipos as $equipo) {
            Equipo::create([
                'id' => $equipo['id'],
                'nombre' => $equipo['nombre'],
                'grupo' => $equipo['grupo'],
                'centro_id' => $equipo['centro_id'],
                'usuarioIdCreacion' => $id_usuario,
            ]);
        }
    }
}
