<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    private $centros = [
        ['nombre' => 'IES Besaya'],
        ['nombre' => 'IES Zapatón'],
        ['nombre' => 'IES Miguel Herrero'],
        ['nombre'=>'De los tres centros']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->centros as $centro) {
            Centro::create([
                'nombre' => $centro['nombre']
            ]);
        }
    }
}
