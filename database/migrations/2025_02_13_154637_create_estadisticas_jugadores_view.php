<?php

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
        DB::statement("
            CREATE VIEW estadisticas_jugadores_view AS
            SELECT 
                j.id AS jugador_id,
                j.nombre,
                j.apellido1,
                j.apellido2,
                SUM(CASE WHEN a.incidencia = 'goles' THEN 1 ELSE 0 END) AS goles,
                SUM(CASE WHEN a.incidencia = 'asistencias' THEN 1 ELSE 0 END) AS asistencias,
                SUM(CASE WHEN a.incidencia = 'tarjetas' THEN 1 ELSE 0 END) AS tarjetas,
                SUM(CASE WHEN a.incidencia = 'lesiones' THEN 1 ELSE 0 END) AS lesiones
            FROM jugadores j
            LEFT JOIN actas a ON j.id = a.jugador_id
            GROUP BY j.id, j.nombre, j.apellido1, j.apellido2
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
