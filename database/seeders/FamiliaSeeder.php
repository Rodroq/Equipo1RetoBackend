<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamiliaSeeder extends Seeder
{
    private $familias = [["nombre" => "Imagen Personal"], ["nombre" => "Imagen y Sonido"], ["nombre" => "Electricidad y Electrónica"], ["nombre" => "Informática y Comunicaciones"],
    ["nombre" => "Transporte y Mantenimiento de Vehículos"],["nombre" => "Textil, Confección y Piel"],["nombre" => "Hostelería y Turismo"],["nombre" => "Comercio y Marketing"],
    ["nombre" => "Servicios socioculturales a la comunidad"]];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($familias as $familia) {
            Familia::create([
                "nombre" => $familia["nombre"]
            ]);
        }        
    }
}
