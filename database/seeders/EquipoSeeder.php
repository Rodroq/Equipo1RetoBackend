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
        $id_usuario = User::find(5)->id;

       // $centros = Centro::get();

        $centro_besaya = Centro::find(1);
        $centro_zapa = Centro::find(2);
        $centro_miguel = Centro::find(3);
        $centro_todo=Centro::find(4);
        $equipos = [
            ['id' => 1, 'nombre' => 'Los Galácticos de Montepinar', 'grupo' => 'A', 'centro_id' => $centro_miguel->id],
            ['id' => 2, 'nombre' => 'Oxido Cero', 'grupo' => 'B', 'centro_id' => $centro_miguel->id],
            ['id' => 3, 'nombre' => 'Leones de Carrocería F.C.', 'grupo' => 'A', 'centro_id' => $centro_miguel->id],
            ['id' => 4, 'nombre' => 'Los Zapa-autómatas F.C.', 'grupo' => 'A', 'centro_id' => $centro_zapa->id],
            ['id' => 5, 'nombre' => 'GRAFCET F.C', 'grupo' => 'B', 'centro_id' => $centro_zapa->id],
            ['id' => 6, 'nombre' => 'Los Acoples FC', 'grupo' => 'A', 'centro_id' => $centro_zapa->id],
            ['id' => 7, 'nombre' => 'Los Leones del Besaya', 'grupo' => 'A', 'centro_id' => $centro_besaya->id],
            ['id' => 8, 'nombre' => 'Xabineta', 'grupo' => 'B', 'centro_id' => $centro_besaya->id], 
            ['id' => 9, 'nombre' => 'Te Miro y Te Integro', 'grupo' => 'B', 'centro_id' => $centro_besaya->id],
            ['id' => 10, 'nombre' => 'Equipo Olimpico', 'grupo' => 'A', 'centro_id' => $centro_todo->id],
            
            
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
