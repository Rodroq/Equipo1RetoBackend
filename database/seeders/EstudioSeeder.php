<?php

namespace Database\Seeders;

use App\Models\Centro;
use App\Models\Estudio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $centros = Centro::get();
        $centro_first_id = $centros->first()->id;//besaya
        $centro_second_id = $centros->get(1)->id;//zapatón
        $centro_last_id = $centros->get(2)->id;//miguel herrero


        $estudios = [
            //Fps de Besaya
            ['id' => 1, 'centro_id' => $centro_first_id, 'ciclo_id' => 1, 'curso' => 1],
            ['id' => 2, 'centro_id' => $centro_first_id, 'ciclo_id' => 2, 'curso' => 1],
            ['id' => 3, 'centro_id' => $centro_first_id, 'ciclo_id' => 3, 'curso' => 1],
            ['id' => 4, 'centro_id' => $centro_first_id, 'ciclo_id' => 4, 'curso' => 1],
            ['id' => 5, 'centro_id' => $centro_first_id, 'ciclo_id' => 5, 'curso' => 1],
            ['id' => 6, 'centro_id' => $centro_first_id, 'ciclo_id' => 6, 'curso' => 1],
            //Fps de Zapaton
            ['id' => 7, 'centro_id' => $centro_second_id, 'ciclo_id' => 7, 'curso' => 1],
            ['id' => 8, 'centro_id' => $centro_second_id, 'ciclo_id' => 8, 'curso' => 1],
            ['id' => 9, 'centro_id' => $centro_second_id, 'ciclo_id' => 9, 'curso' => 1],
            ['id' => 10, 'centro_id' => $centro_second_id, 'ciclo_id' => 10, 'curso' => 1],
            ['id' => 11, 'centro_id' => $centro_second_id, 'ciclo_id' => 11, 'curso' => 1],
            ['id' => 12, 'centro_id' => $centro_second_id, 'ciclo_id' => 12, 'curso' => 1],
            //Fps de Miguel Herrero Pereda
            ['id' => 13, 'centro_id' => $centro_last_id, 'ciclo_id' => 13, 'curso' => 1],
            ['id' => 14, 'centro_id' => $centro_last_id, 'ciclo_id' => 14, 'curso' => 1],
            ['id' => 15, 'centro_id' => $centro_last_id, 'ciclo_id' => 15, 'curso' => 1],
            ['id' => 16, 'centro_id' => $centro_last_id, 'ciclo_id' => 16, 'curso' => 1],
            ['id' => 17, 'centro_id' => $centro_last_id, 'ciclo_id' => 17, 'curso' => 1],
        ];

        foreach ($estudios as $estudio) {
            Estudio::create([
                'id' => $estudio['id'],
                'centro_id' => $estudio['centro_id'],
                'ciclo_id' => $estudio['ciclo_id'],
                'curso' => $estudio['curso'],
            ]);
        }
    }
}
