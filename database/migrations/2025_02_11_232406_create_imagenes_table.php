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
use App\Models\Publicacion;
use App\Models\Reto;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('url', 45);
            $table->string('nombre', 45);

            //Gestion de relaciones con imagenes a través de claves polimorficas para evitar crear las FK
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');

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
        Schema::dropIfExists('imagenes');
    }
};
