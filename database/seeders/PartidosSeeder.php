<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartidosSeeder extends Seeder
{
    private $partidos = [
        
        ['fecha' => '2025-03-13', 'hora' => '10:00:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 1, 'equipoV' =>3 ],
        ['fecha' => '2025-03-13', 'hora' => '10:15:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 2, 'equipoV' =>8 ],
        ['fecha' => '2025-03-13', 'hora' => '10:30:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 7, 'equipoV' =>4 ],
        ['fecha' => '2025-03-13', 'hora' => '10:45:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 9, 'equipoV' =>5 ],
        ['fecha' => '2025-03-13', 'hora' => '11:00:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 6, 'equipoV' =>1 ],
        ['fecha' => '2025-03-13', 'hora' => '11:15:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 10, 'equipoV' =>2 ],
        ['fecha' => '2025-03-13', 'hora' => '11:30:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 3, 'equipoV' =>7 ],
        ['fecha' => '2025-03-13', 'hora' => '11:45:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' =>9 ],
        
        ['fecha' => '2025-03-13', 'hora' => '12:45:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' =>6 ],
        ['fecha' => '2025-03-13', 'hora' => '13:00:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 5, 'equipoV' =>10 ],
        ['fecha' => '2025-03-13', 'hora' => '13:15:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 1, 'equipoV' =>7 ],
        ['fecha' => '2025-03-13', 'hora' => '13:30:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 2, 'equipoV' =>9 ],
        ['fecha' => '2025-03-13', 'hora' => '13:45:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 3, 'equipoV' =>4 ],
             
        ['fecha' => '2025-03-14', 'hora' => '10:00:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' =>5 ],
        ['fecha' => '2025-03-14', 'hora' => '10:15:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 6, 'equipoV' =>3 ],
        ['fecha' => '2025-03-14', 'hora' => '10:30:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 10, 'equipoV' =>5 ],
        ['fecha' => '2025-03-14', 'hora' => '10:45:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' =>7, 'equipoV' =>6 ],
        ['fecha' => '2025-03-14', 'hora' => '11:00:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 9, 'equipoV' =>10 ],
        ['fecha' => '2025-03-14', 'hora' => '11:15:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' =>1 ],
        ['fecha' => '2025-03-14', 'hora' => '11:30:00', 'golesL' => 0, 'golesV' => 0, 'usuarioIdCreacion' => 1, 'equipoL' => 5, 'equipoV' =>2 ],
        
        
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pabellon_id = DB::table('pabellones')->first()->id;

        $id_usuario = User::first()->id;
        foreach($this->partidos as $partido){
            Partido::create([
                'fecha' => $partido['fecha'],
                'hora' => $partido['hora'],
                'golesL' => $partido['golesL'],
                'golesV' => $partido['golesV'],
                'usuarioIdCreacion' => $id_usuario,
                'equipoL' => $partido['equipoL'],
                'equipoV' => $partido['equipoV'],
                'pabellon_id' => $pabellon_id,
            ]);
        }
    }
}
