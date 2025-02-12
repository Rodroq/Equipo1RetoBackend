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
            $table->longText('texto')->nullable();
            $table->tinyInteger('portada')->nullable();
            $table->string('rutavideo', 45)->nullable();
            $table->string('rutaaudio', 45)->nullable();

            //clave foranea para los equipos
            $table->foreignIdFor(Equipo::class)->nullable()->constrained()->cascadeOnDelete();

            //clave foranea para los partido
            $table->foreignIdFor(Partido::class)->nullable()->constrained()->cascadeOnDelete();

            //clave foranea para los patrociandores

            $table->foreignIdFor(Patrocinador::class)->nullable()->constrained()->cascadeOnDelete();

            //clave foranea para los jugadores
            $table->foreignIdFor(Jugador::class)->nullable()->constrained()->cascadeOnDelete();

            //clave foranea para los reto
            $table->foreignIdFor(Reto::class)->nullable()->constrained()->cascadeOnDelete();

            //clave foranea para los ong
            $table->unsignedBigInteger('ong_id')->nullable();
            $table->foreign('ong_id')->references('id')->on('ongs')->cascadeOnDelete();

            //clave foranea para los pabellon
            $table->unsignedBigInteger('pabellon_id')->nullable();
            $table->foreign('pabellon_id')->references('id')->on('pabellones')->cascadeOnDelete();

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
