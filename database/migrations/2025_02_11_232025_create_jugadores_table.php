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
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('apellido1', 45)->nullable();
            $table->string('apellido2', 45)->nullable();
            $table->enum('tipo', ['jugador', 'capitan', 'entrenador'])->nullable();
            $table->char('dni', 9)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->smallInteger('goles')->nullable();
            $table->smallInteger('asistencias')->nullable();
            $table->smallInteger('tarjetas_amarillas')->nullable();
            $table->smallInteger('tarjetas_rojas')->nullable();
            $table->smallInteger('lesiones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
