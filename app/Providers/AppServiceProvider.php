<?php

namespace App\Providers;

use App\Models\{Equipo,Jugador};
use App\Policies\{EquipoPolicy,JugadorPolicy, MediaPolicy};
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
                Equipo::class => EquipoPolicy::class,
                Jugador::class => JugadorPolicy::class,
                Media::class => MediaPolicy::class,
            };
        });
    }
}
