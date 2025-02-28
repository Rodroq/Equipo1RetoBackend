<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pabellon extends Model
{
    use HasSlug;

    protected $table = 'pabellones';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pabellon_imagenes')
            ->useDisk('images_tournament')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg']);
    }

    public function partido()
    {
        return $this->hasMany(Partido::class);
    }

    public function publicaciones(): MorphMany
    {
        return $this->morphMany(Publicacion::class, 'publicacionable')->chaperone('pabellon');
    }
}
