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
        ['fecha' => '2025-02-19', 'hora' => '16:34:00', 'golesL' => 1, 'golesV' => 3, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' => 7 ],
        ['fecha' => '2025-02-12', 'hora' => '18:54:00', 'golesL' => 4, 'golesV' => 1, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' => 7 ],
        ['fecha' => '2025-02-24', 'hora' => '13:03:00', 'golesL' => 5, 'golesV' => 1, 'usuarioIdCreacion' => 1, 'equipoL' => 4, 'equipoV' => 2 ],
        ['fecha' => '2025-02-25', 'hora' => '13:10:00', 'golesL' => 2, 'golesV' => 5, 'usuarioIdCreacion' => 1, 'equipoL' => 3, 'equipoV' => 5 ],
        ['fecha' => '2025-02-14', 'hora' => '12:26:00', 'golesL' => 2, 'golesV' => 2, 'usuarioIdCreacion' => 1, 'equipoL' => 8, 'equipoV' => 7 ]
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
