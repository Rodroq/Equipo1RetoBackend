<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Ong;
use App\Models\Pabellon;
use App\Models\Partido;
use App\Models\Patrocinador;
use App\Models\Reto;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 45)->nullable();
            $table->string('slug', 45);
            $table->longText('texto')->nullable();
            $table->tinyInteger('portada')->nullable();
            $table->string('rutavideo', 255)->nullable();
            $table->string('rutaaudio', 255)->nullable();


            //relacion de tablas a raíz de clave polimorfica 1:M
            $table->integer('publicacionable_id');
            $table->string('publicacionable_type');

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
        Schema::dropIfExists('publicaciones');
    }
};
