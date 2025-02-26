<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pabellon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            // Añadir las columna de equipoL, equipoV
            $table->unsignedBigInteger('equipoL')->nullable();
            $table->unsignedBigInteger('equipoV')->nullable();
            $table->unsignedBigInteger('pabellon_id')->nullable();

            // Definir la clave foránea con la tabla equipos
            $table->foreign('equipoL')->references('id')->on('equipos')->cascadeOnDelete();

            // Definir la clave foránea con la tabla equipos
            $table->foreign('equipoV')->references('id')->on('equipos')->cascadeOnDelete();

            //Definir la clave foranea con la tabla de pabellones
            $table->foreign('pabellon_id')->references('id')->on('pabellones')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partidos', function (Blueprint $table) {
            //Eliminar las claves foraneas
            $table->dropForeign(['equipoL']);
            $table->dropForeign(['equipoV']);
            $table->dropForeign(['pabellon_id']);

            //Eliminar la nueva columna creada
            $table->dropColumn('equipoL');
            $table->dropColumn('equipoV');
            $table->dropColumn('pabellon_id');
        });
    }
};
