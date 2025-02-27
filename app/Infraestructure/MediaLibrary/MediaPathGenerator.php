<?php

namespace App\Infraestructure\MediaLibrary;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class MediaPathGenerator implements PathGenerator
{
    /**
     * Ruta donde se almacenará la imagen.
     */
    public function getPath(Media $media): string
    {
        return "{$media->model_type}/";
    }

    /**
     * Ruta donde se almacenarán las conversiones (miniaturas, etc.).
     */
    public function getPathForConversions(Media $media): string
    {
        return "{$media->model_type}/conversions/";
    }

    /**
     * Ruta para imágenes responsivas.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return "{$media->model_type}/responsive/";
    }
}
