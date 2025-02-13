<?php

namespace Database\Seeders;

use App\Models\Centro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    private $centros = [
        ['id' => 1, 'nombre' => 'IES Besaya'],
        ['id' => 2, 'nombre' => 'IES Zapatón'],
        ['id' => 3, 'nombre' => 'IES Miguel Herrero'],
        ['id' => 4, 'nombre' => 'IES Zapatón'],
        ['id' => 5, 'nombre' => 'IES Cantabria'],
        ['id' => 6, 'nombre' => 'IES Santa Clara'],
        ['id' => 7, 'nombre' => 'CIFP Número Uno'],
        ['id' => 8, 'nombre' => 'IES La Albericia'],
        ['id' => 9, 'nombre' => 'IES Marqués de Manzanedo'],
        ['id' => 10, 'nombre' => 'IES Valle de Piélagos'],
        ['id' => 11, 'nombre' => 'IES José María Pereda'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->centros as $centro) {
            Centro::create([
                'id' => $centro['id'],
                'nombre' => $centro['nombre']
            ]);
        }
    }
}
