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
        $crear_equipo_permiso = Permission::firstOrCreate(['name' => 'create football team']);
        $editar_equipo_permiso = Permission::firstOrCreate(['name' => 'edit football team']);
        $borrar_equipo_permiso = Permission::firstOrCreate(['name' => 'delete football team']);

        // jugadores C - U D
        $crear_jugador_permiso = Permission::firstOrCreate(['name' => 'create player']);
        $editar_jugador_permiso = Permission::firstOrCreate(['name' => 'edit player']);
        $borrar_jugador_permiso = Permission::firstOrCreate(['name' => 'delete player']);

        // patrocinadores C - U D
        $crear_patrocinador_permiso = Permission::firstOrCreate(['name' => 'create sponsor']);
        $editar_patrocinador_permiso = Permission::firstOrCreate(['name' => 'edit sponsor']);
        $borrar_patrocinador_permiso = Permission::firstOrCreate(['name' => 'delete sponsor']);


        /* permisos para los roles de periodista y administrador */
        $crear_publicaciones_permiso = Permission::firstOrCreate(['name' => 'create publication']);
        $editar_publicaciones_permiso = Permission::firstOrCreate(['name' => 'edit publication']);
        $borrar_publicaciones_permiso = Permission::firstOrCreate(['name' => 'delete publication']);


        /* permisos para los directores del torneo y administradores */

        //partidos C - - D
        $crear_partidos_permiso = Permission::firstOrCreate(['name' => 'create match']);
        $borrar_partidos_permiso = Permission::firstOrCreate(['name' => 'delete match']);

        //actas C R U D
        $crear_actas_permiso = Permission::firstOrCreate(['name' => 'create proceedings']);
        $leer_actas_permiso = Permission::firstOrCreate(['name' => 'read proceedings']);               //posiblemente innecesario
        $editar_actas_permiso = Permission::firstOrCreate(['name' => 'edit proceedings']);             //posiblemente innecesario
        $borrar_actas_permiso = Permission::firstOrCreate(['name' => 'delete proceedings']);           //posiblemente innecesario

        //imagenes C - U D
        $crear_imagen_permiso = Permission::firstOrCreate(['name' => 'create image']);
        $editar_imagen_permiso = Permission::firstOrCreate(['name' => 'edit image']);
        $borrar_imagen_permiso = Permission::firstOrCreate(['name' => 'delete image']);

        //inscripciones - R U -
        $crear_inscripcion_permiso = Permission::firstOrCreate(['name' => 'create registration']);     //posiblemente innecesario
        $leer_inscripcion_permiso = Permission::firstOrCreate(['name' => 'read registration']);
        $editar_inscripcion_permiso = Permission::firstOrCreate(['name' => 'edit registration']);



        /* Sección de los roles de la web */

        $entrenador = Role::create(['name' => 'coach']);
        $director_torneo = Role::create(['name' => 'director']);
        $periodista = Role::create(['name' => 'reporter']);
        $administrador = Role::create(['name' => 'administrator']);



        /* Asignar permisos a los roles */
        $entrenador->syncPermissions(
            $crear_equipo_permiso,
            $editar_equipo_permiso,
            $borrar_equipo_permiso,
            $crear_jugador_permiso,
            $editar_jugador_permiso,
            $borrar_jugador_permiso,
            $crear_patrocinador_permiso,
            $editar_patrocinador_permiso,
            $borrar_patrocinador_permiso,
            $crear_imagen_permiso,
            $editar_imagen_permiso,
            $borrar_imagen_permiso,
            $crear_inscripcion_permiso
        );

        $director_torneo->syncPermissions(
            $crear_actas_permiso,
            $leer_actas_permiso,
            $editar_actas_permiso,
            $borrar_actas_permiso,
            $crear_partidos_permiso,
            $borrar_partidos_permiso
        );

        $periodista->syncPermissions(
            $crear_publicaciones_permiso,
            $editar_publicaciones_permiso,
            $borrar_publicaciones_permiso,
            $crear_imagen_permiso,
            $editar_imagen_permiso,
            $borrar_imagen_permiso
        );

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
            $borrar_imagen_permiso,
            $leer_inscripcion_permiso,
            $editar_inscripcion_permiso
        );
    }
}
