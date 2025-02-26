<?php

use App\Models\Jugador;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Partido;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->foreignIdFor(Partido::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Jugador::class)->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Partido::class);
            $table->dropConstrainedForeignIdFor(Jugador::class);
        });
    }
};
