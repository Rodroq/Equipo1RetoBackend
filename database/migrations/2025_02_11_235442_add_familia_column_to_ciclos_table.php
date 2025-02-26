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
        Schema::table('ciclos', function (Blueprint $table) {
            // Añadir la columna de familias
            $table->unsignedBigInteger('familia_id')->nullable();

            // Definir las claves foráneas con la tabla familias
            $table->foreign('familia_id')->references('id')->on('familias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ciclos', function (Blueprint $table) {
            //Eliminar la clave foranea
            $table->dropForeign(['familia_id']);

            //Eliminar la nueva columna creada
            $table->dropColumn('familia_id');
        });
    }
};
