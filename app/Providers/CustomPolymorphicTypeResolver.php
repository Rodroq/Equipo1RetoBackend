<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class CustomPolymorphicTypeResolver extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'usuarios' => 'App\Models\User',
            'equipos' => 'App\Models\Equipo',
            'jugadores' => 'App\Models\Jugador',
            'pabellones' => 'App\Models\Pabellon',
            'partidos' => 'App\Models\Partido',
            'patrocinadores' => 'App\Models\Patrocinador',
            'publicaciones' => 'App\Models\Publicacion',
            'retos' => 'App\Models\Reto',
        ]);
    }
}
