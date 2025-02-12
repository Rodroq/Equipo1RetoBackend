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
        Schema::table('estudios', function (Blueprint $table) {
            // Añadir las columna de centro y ciclo
            $table->unsignedBigInteger('centro_id');
            $table->unsignedBigInteger('ciclo_id')->nullable();

            // Definir las claves foráneas con la tabla centros
            $table->foreign('centro_id')->references('id')->on('centros')->cascadeOnDelete();

            // Definir las claves foráneas con la tabla ciclos
            $table->foreign('ciclo_id')->references('id')->on('ciclos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudios', function (Blueprint $table) {
            //Eliminar las claves foranea
            $table->dropForeign(['centro_id']);
            $table->dropForeign(['ciclo_id']);

            //Eliminar las nuevas columnas creadas
            $table->dropColumn('centro_id');
            $table->dropColumn('ciclo_id');
        });
    }
};
