<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS estadisticas_partidos_view");

        DB::statement("
            CREATE VIEW estadisticas_partidos_view AS
            SELECT 
                p.id AS partido_id,
                p.fecha,
                p.equipoL,
                p.equipoV,
                l.nombre AS local,
                v.nombre AS visitante,
                SUM(CASE 
                    WHEN a.incidencia = 'goles' AND j.equipo_id = p.equipoL 
                    THEN 1 ELSE 0 
                END) AS goles_local,
                SUM(CASE 
                    WHEN a.incidencia = 'goles' AND j.equipo_id = p.equipoV 
                    THEN 1 ELSE 0 
                END) AS goles_visitante
            FROM partidos p
            LEFT JOIN actas a ON p.id = a.partido_id
            LEFT JOIN jugadores j ON a.jugador_id = j.id  -- Optimización: evita subconsulta
            LEFT JOIN equipos l ON p.equipoL = l.id
            LEFT JOIN equipos v ON p.equipoV = v.id
            GROUP BY p.id, p.fecha, p.equipoL, p.equipoV, l.nombre, v.nombre;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS estadisticas_partidos_view");
    }
};
