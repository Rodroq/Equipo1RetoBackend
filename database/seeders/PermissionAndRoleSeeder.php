<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* Sección de permisos de la web */

        /* permisos para los roles de usuario (profesor) y administrador */

        // equipos C - U D
        Permission::firstOrCreate(['name' => 'crear_equipo']);
        $editar_equipo_permiso = Permission::firstOrCreate(['name' => 'editar_equipo']);
        $borrar_equipo_permiso = Permission::firstOrCreate(['name' => 'borrar_equipo']);

        // jugadores C - U D
        Permission::firstOrCreate(['name' => 'crear_jugador']);
        $editar_jugador_permiso = Permission::firstOrCreate(['name' => 'editar_jugador']);
        $borrar_jugador_permiso = Permission::firstOrCreate(['name' => 'borrar_jugador']);

        // patrocinadores C - U D
        Permission::firstOrCreate(['name' => 'crear_patrocinador']);
        $editar_patrocinador_permiso = Permission::firstOrCreate(['name' => 'editar_patrocinador']);
        $borrar_patrocinador_permiso = Permission::firstOrCreate(['name' => 'borrar_patrocinador']);


        /* permisos para los roles de periodista y administrador */
        Permission::firstOrCreate(['name' => 'crear_publicacion']);
        $editar_publicaciones_permiso = Permission::firstOrCreate(['name' => 'editar_publicacion']);
        $borrar_publicaciones_permiso = Permission::firstOrCreate(['name' => 'borrar_publicacion']);


        /* permisos para los directores del torneo y administradores */

        //partidos C - - D
        Permission::firstOrCreate(['name' => 'crear_partido']);
        $borrar_partidos_permiso = Permission::firstOrCreate(['name' => 'borrar_partido']);

        //actas C R U D
        Permission::firstOrCreate(['name' => 'crear_acta']);
        $leer_actas_permiso = Permission::firstOrCreate(['name' => 'leer_acta']);
        $editar_actas_permiso = Permission::firstOrCreate(['name' => 'editar_acta']);                        //posiblemente innecesario
        $borrar_actas_permiso = Permission::firstOrCreate(['name' => 'borrar_acta']);                        //posiblemente innecesario

        //inscripciones - R U -
        $leer_inscripcion_permiso = Permission::firstOrCreate(['name' => 'leer_inscripcion']);
        $editar_inscripcion_permiso = Permission::firstOrCreate(['name' => 'editar_inscripcion']);

        $crear_imagen = Permission::firstOrCreate(['name' => 'crear_imagen']);
        $editar_imagen = Permission::firstOrCreate(['name' => 'editar_imagen']);
        $borrar_imagen = Permission::firstOrCreate(['name' => 'borrar_imagen']);


        Role::create(['name' => 'entrenador']);
        Role::create(['name' => 'director']);
        Role::create(['name' => 'periodista']);


        /* Asignar permisos al rol administrador */
        $administrador = Role::create(['name' => 'administrador']);
        $administrador->syncPermissions(
            $editar_equipo_permiso,
            $borrar_equipo_permiso,
            $editar_jugador_permiso,
            $borrar_jugador_permiso,
            $editar_patrocinador_permiso,
            $borrar_patrocinador_permiso,
            $editar_publicaciones_permiso,
            $borrar_publicaciones_permiso,
            $borrar_partidos_permiso,
            $leer_actas_permiso,
            $editar_actas_permiso,
            $borrar_actas_permiso,
            $crear_imagen,
            $editar_imagen,
            $borrar_imagen,
            $leer_inscripcion_permiso,
            $editar_inscripcion_permiso
        );
    }
}
