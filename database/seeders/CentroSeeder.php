<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroSeeder extends Seeder
{
    private $centros = [["nombre" => "IES Besaya"], ["nombre" => "IES Miguel Herrero"], ["nombre" => "IES Zapatón"]];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($centros as $centro) {
            Centro::create([
                "nombre" => $centro["nombre"]
            ]);
        }        
    }
}
