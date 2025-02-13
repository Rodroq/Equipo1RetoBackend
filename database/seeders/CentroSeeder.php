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
