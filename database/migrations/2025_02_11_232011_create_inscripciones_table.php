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
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->longText('comentarios');
            $table->enum('estado',['pendiente','aprobada','rechazada'])->nullable();
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
        Schema::dropIfExists('inscripciones');
    }
};
