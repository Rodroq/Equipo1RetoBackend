<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Equipo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            $table->foreignIdFor(Equipo::class)->constrained()->cascadeOnDelete();

            // Añadir las columna de estudio
            $table->unsignedBigInteger('estudio_id')->nullable();

            // Definir las claves foráneas con la tabla estudios
            $table->foreign('estudio_id')->references('id')->on('estudios')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jugadores', function (Blueprint $table) {
            //Eliminar las claves foraneas
            $table->dropConstrainedForeignIdFor(Equipo::class);
            $table->dropForeign(['estudio_id']);

            //Eliminar la nueva columna creada
            $table->dropColumn('estudio_id');
        });
    }
};
