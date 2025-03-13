<?php

namespace Database\Seeders;

use App\Models\Inscripcion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InscripcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar la tabla antes de insertar (opcional)
        DB::table('inscripciones')->truncate();

        // Datos de las inscripciones ajustados a los equipos del EquipoSeeder
        $inscripciones = [
            [
                'slug' => 'los-galacticos-de-montepinar-inscripcion',
                'comentarios' => 'Inscripción aprobada para Los Galácticos',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => 20,
                'fechaActualizacion' => now(),
                'equipo_id' => 1, // Los Galácticos de Montepinar
            ],
            [
                'slug' => 'oxido-cero-inscripcion',
                'comentarios' => 'Inscripción aprobada para Oxido Cero',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 2, // Oxido Cero
            ],
            [
                'slug' => 'leones-de-carroceria-fc-inscripcion',
                'comentarios' => 'Inscripción aprobada para Leones de Carrocería',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 3, // Leones de Carrocería F.C.
            ],
            [
                'slug' => 'los-zapa-automas-fc-inscripcion',
                'comentarios' => 'Inscripción aprobada para Los Zapa-autómatas',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 4, // Los Zapa-autómatas F.C.
            ],
            [
                'slug' => 'grafcet-fc-inscripcion',
                'comentarios' => 'Inscripción aprobada para GRAFCET',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 5, // GRAFCET F.C
            ],
            [
                'slug' => 'los-acoples-fc-inscripcion',
                'comentarios' => 'Inscripción aprobada para Los Acoples',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 6, // Los Acoples FC
            ],
            [
                'slug' => 'los-leones-del-besaya-inscripcion',
                'comentarios' => 'Inscripción aprobada para Los Leones del Besaya',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 7, // Los Leones del Besaya
            ],
            [
                'slug' => 'xabineta-inscripcion',
                'comentarios' => 'Inscripción aprobada para Xabineta',
                'estado' => 'aprobada',
                'usuarioIdCreacion' => 16,
                'fechaCreacion' => now(),
                'usuarioIdActualizacion' => null,
                'fechaActualizacion' => null,
                'equipo_id' => 8, // Xabineta
            ],
        ];

        // Insertar los datos en la tabla
        foreach ($inscripciones as $inscripcion) {
            Inscripcion::create($inscripcion);
        }
    }
}