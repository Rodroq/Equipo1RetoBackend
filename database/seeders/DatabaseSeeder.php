<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();
        DB::table('centros')->delete();
        DB::table('pabellones')->delete();
        DB::table('ongs')->delete();
        DB::table('familias')->delete();
        DB::table('ciclos')->delete();
        DB::table('estudios')->delete();
        DB::table('retos')->delete();
        DB::table('equipos')->delete();
        DB::table('jugadores')->delete();
        DB::table('partidos')->delete();
        DB::table('actas')->delete();
        DB::table('inscripciones')->delete();

        $this->call(PermissionAndRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CentroSeeder::class);
        $this->call(PabellonSeeder::class);
        $this->call(OngSeeder::class);
        $this->call(FamiliaSeeder::class);
        $this->call(CicloSeeder::class);
        $this->call(EstudioSeeder::class);
        $this->call(RetoSeeder::class);
        $this->call(EquipoSeeder::class);
        $this->call(JugadorSeeder::class);
        $this->call(PartidosSeeder::class);
        $this->call(ActasSeeder::class);
        $this->call(InscripcionesSeeder::class);

    }
}
