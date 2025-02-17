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
        DB::statement("DROP VIEW IF EXISTS estadisticas_jugadores_view");

        DB::statement("
            CREATE VIEW estadisticas_jugadores_view AS
            SELECT
                j.id AS jugador_id,
                SUM(CASE WHEN a.incidencia = 'goles' THEN 1 ELSE 0 END) AS goles,
                SUM(CASE WHEN a.incidencia = 'asistencias' THEN 1 ELSE 0 END) AS asistencias,
                SUM(CASE WHEN a.incidencia = 'tarjetas_amarillas' THEN 1 ELSE 0 END) AS tarjetas_amarillas,
                SUM(CASE WHEN a.incidencia = 'tarjetas_rojas' THEN 1 ELSE 0 END) AS tarjetas_rojas,
                SUM(CASE WHEN a.incidencia = 'lesiones' THEN 1 ELSE 0 END) AS lesiones
            FROM jugadores j
            LEFT JOIN actas a ON j.id = a.jugador_id
            GROUP BY j.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS estadisticas_jugadores_view");
    }
};
