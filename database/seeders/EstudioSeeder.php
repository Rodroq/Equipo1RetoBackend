<?php

namespace Database\Seeders;

use App\Models\Estudio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstudioSeeder extends Seeder
{
    private $estudios = [
        //Fps de Besaya
        ['centro_id' => 1, 'ciclo_id' => 1, 'curso' => 1],
        ['centro_id' => 1, 'ciclo_id' => 2, 'curso' => 1],
        ['centro_id' => 1, 'ciclo_id' => 3, 'curso' => 1],
        ['centro_id' => 1, 'ciclo_id' => 4, 'curso' => 1],
        ['centro_id' => 1, 'ciclo_id' => 5, 'curso' => 1],
        ['centro_id' => 1, 'ciclo_id' => 6, 'curso' => 1],
        //Fps de Zapaton
        ['centro_id' => 2, 'ciclo_id' => 7, 'curso' => 1],
        ['centro_id' => 2, 'ciclo_id' => 8, 'curso' => 1],
        ['centro_id' => 2, 'ciclo_id' => 9, 'curso' => 1],
        ['centro_id' => 2, 'ciclo_id' => 10, 'curso' => 1],
        ['centro_id' => 2, 'ciclo_id' => 11, 'curso' => 1],
        ['centro_id' => 2, 'ciclo_id' => 12, 'curso' => 1],
        //Fps de Miguel Herrero Pereda
        ['centro_id' => 3, 'ciclo_id' => 13, 'curso' => 1],
        ['centro_id' => 3, 'ciclo_id' => 14, 'curso' => 1],
        ['centro_id' => 3, 'ciclo_id' => 15, 'curso' => 1],
        ['centro_id' => 3, 'ciclo_id' => 16, 'curso' => 1],
        ['centro_id' => 3, 'ciclo_id' => 17, 'curso' => 1],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->estudios as $estudio) {
            Estudio::create([
                'centro_id' => $estudio['centro_id'],
                'ciclo_id' => $estudio['ciclo_id'],
                'curso' => $estudio['curso'],
            ]);
        }
    }
}
