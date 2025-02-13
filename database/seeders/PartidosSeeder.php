<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartidosSeeder extends Seeder
{
    private $partidos = [
        [ 'id' => 1, 'fecha' => '2025-02-19', 'hora' => '16:34:00', 'golesL' => 1, 'golesV' => 3, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' => 7, 'pabellon_id' => 1 ],
        [ 'id' => 2, 'fecha' => '2025-02-12', 'hora' => '18:54:00', 'golesL' => 4, 'golesV' => 1, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' => 7, 'pabellon_id' => 1 ],
        [ 'id' => 3, 'fecha' => '2025-02-24', 'hora' => '13:03:00', 'golesL' => 5, 'golesV' => 1, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' => 2, 'pabellon_id' => 1 ],
        [ 'id' => 4, 'fecha' => '2025-02-25', 'hora' => '13:10:00', 'golesL' => 2, 'golesV' => 5, 'usuarioIdCreacion' => 1, 'equipoL' => 3, 'equipoV' => 5, 'pabellon_id' => 1 ],
        [ 'id' => 5, 'fecha' => '2025-02-14', 'hora' => '12:26:00', 'golesL' => 2, 'golesV' => 2, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' => 7, 'pabellon_id' => 1 ]    
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id_usuario = User::first()->id;
        foreach($this->partidos as $partido){
            Partido::create([
                'id' => $partido['id'],
                'fecha' => $partido['fecha'],
                'hora' => $partido['hora'],
                'golesL' => $partido['golesL'],
                'golesV' => $partido['golesV'],
                'usuarioIdCreacion' => $id_usuario,
                'equipoL' => $partido['equipoL'],
                'equipoV' => $partido['equipoV'],
                'pabellon_id' => $partido['pabellon_id'],
            ]);
        }  
    }
}
