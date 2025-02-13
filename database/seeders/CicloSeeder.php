<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CicloSeeder extends Seeder
{

    private $ciclos = [
        //FP del Besaya
        ['id' => 1, 'nombre' => 'FPGB Tapicería y Cortinaje', 'familia_id' => 1], //familia profesional de Textil, Confección y Piel
        ['id' => 2, 'nombre' => 'FPGB Cocina y Restauración', 'familia_id' => 2], //familia profesional de Hostelería y Turismo
        ['id' => 3, 'nombre' => 'FPGM Servicios de Restauración', 'familia_id' => 2], //familia profesional de Hostelería y Turismo
        ['id' => 4, 'nombre' => 'FPGM Comercialización de productos alimenticios', 'familia_id' => 3], //familia profesional de Comercio y Marketing
        ['id' => 5, 'nombre' => 'FPGS Transporte y logística', 'familia_id' => 3], //familia profesional de Comercio y Marketing
        ['id' => 6, 'nombre' => 'FPGS Integración Social', 'familia_id' => 4], //familia profesional de Servicios Socioculturales y a la Comunidad
        //Fps del Zapatón
        ['id' => 7, 'nombre' => 'CFGS Automatización y Robotica Industrial', 'familia_id' => 5], //familia profesional de Electricidad y Electrónica
        ['id' => 8, 'nombre' => 'CFGS Mantenimiento Electronico', 'familia_id' => 5], //familia profesional de Electricidad y Electrónica
        ['id' => 9, 'nombre' => 'CFGS Masaje Estetico', 'familia_id' => 6], //familia profesional de Imagen Personal
        ['id' => 10, 'nombre' => 'CFGS Cosmética aplicada a estética y bienestar', 'familia_id' => 6], //familia profesional de Imagen Personal
        ['id' => 11, 'nombre' => 'CFGS VideoDJ', 'familia_id' => 7], //familia profesional de Imagen y sonido
        ['id' => 12, 'nombre' => 'CFGS Imagen y Sonido', 'familia_id' => 7], //familia profesional de Imagen y sonido
        //Fps del Miguel Herrero
        ['id' => 13, 'nombre' => 'CFGM Sistemas Microinformáticos y Redes', 'familia_id' => 8], //familia profesional de Informatica y comunicaciones
        ['id' => 14, 'nombre' => 'CFGS Despliegue de Aplicaciones Web', 'familia_id' => 8], //familia profesional de Informatica y comunicaciones
        ['id' => 15, 'nombre' => 'CFGS Administración de sistemas informáticos y redes', 'familia_id' => 8], //familia profesional de Informatica y comunicaciones
        ['id' => 16, 'nombre' => 'CFGM Carrocería ', 'familia_id' => 9], //familia profesional de Transporte y mantenimiento
        ['id' => 17, 'nombre' => 'CFGM Gestión Administrativa', 'familia_id' => 10], //familia profesional de Administración y gestión
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->ciclos as $ciclo) {
            DB::table('ciclos')->insert([
                'id' => $ciclo['id'],
                'nombre' => $ciclo['nombre'],
                'familia_id' => $ciclo['familia_id']
            ]);
        }
    }
}
