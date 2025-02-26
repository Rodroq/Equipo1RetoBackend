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
        Schema::create('actas', function (Blueprint $table) {
            $table->id();
            $table->enum('incidencia', ['goles', 'asistencias', 'tarjetas_amarillas','tarjetas_rojas', 'lesiones'])->nullable();
            $table->time('hora')->nullable();
            $table->longText('comentario')->nullable();
            $table->unsignedBigInteger('usuarioIdCreacion');
            $table->timestamp('fechaCreacion')->useCurrent();
            $table->unsignedBigInteger('usuarioIdActualizacion')->nullable();
            $table->timestamp('fechaActualizacion')->nullable()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actas');
    }
};
