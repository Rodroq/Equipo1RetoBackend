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
        Schema::table('equipos', function (Blueprint $table) {
            // Añadir las columna de centro
            $table->unsignedBigInteger('centro_id')->nullable();

            // Definir las claves foráneas con la tabla centros
            $table->foreign('centro_id')->references('id')->on('centros')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            //Eliminar la clave foranea
            $table->dropForeign(['centro_id']);

            //Eliminar la nueva columna creada
            $table->dropColumn('centro_id');
        });
    }
};
