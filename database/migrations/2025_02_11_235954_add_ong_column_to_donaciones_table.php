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
        Schema::table('donaciones', function (Blueprint $table) {
            //clave foranea para los ong
            $table->unsignedBigInteger('ong_id');
            $table->foreign('ong_id')->references('id')->on('ongs')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donaciones', function (Blueprint $table) {
            //Eliminar las claves foraneas
            $table->dropForeign(['ong_id']);

            //Eliminar la nueva columna creada
            $table->dropColumn('ong_id');
        });
    }
};
