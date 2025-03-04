<?php

namespace App\Providers;

use App\Models\{Acta, Equipo, Jugador, Patrocinador, Publicacion};
use App\Policies\{ActaPolicy, EquipoPolicy, JugadorPolicy, MediaPolicy, PatrocinadorPolicy, PublicacionPolicy};
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::guessPolicyNamesUsing(function (string $modelClass) {
            return match ($modelClass) {
                Acta::class => ActaPolicy::class,
                Equipo::class => EquipoPolicy::class,
                Jugador::class => JugadorPolicy::class,
                Media::class => MediaPolicy::class,
                Patrocinador::class => PatrocinadorPolicy::class,
                Publicacion::class => PublicacionPolicy::class,
            };
        });
    }
}
