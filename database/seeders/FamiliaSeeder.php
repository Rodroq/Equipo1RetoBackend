<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FamiliaSeeder extends Seeder
{
    private $familias = [
        ['id' => 1, 'nombre' => 'Textil, Confección y Piel'],
        ['id' => 2, 'nombre' => 'Hostelería y Turismo'],
        ['id' => 3, 'nombre' => 'Comercio y Marketing'],
        ['id' => 4, 'nombre' => 'Servicios socioculturales a la comunidad'],
        ['id' => 5, 'nombre' => 'Electricidad y Electrónica'],
        ['id' => 6, 'nombre' => 'Imagen Personal'],
        ['id' => 7, 'nombre' => 'Imagen y Sonido'],
        ['id' => 8, 'nombre' => 'Informática y Comunicaciones'],
        ['id' => 9, 'nombre' => 'Transporte y Mantenimiento de Vehículos'],
        ['id' => 10, 'nombre' => 'Administración gestión'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->familias as $familia) {
            DB::table('familias')->insert([
                'id' => $familia['id'],
                'nombre' => $familia['nombre']
            ]);
        }
    }
}
