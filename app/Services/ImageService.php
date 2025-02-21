<?php

namespace App\Services;

use App\Models\Imagen;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;


final class ImageService
{
    public function getImages($model, string $collection = 'default')
    {
        return $model->getMedia($collection);
    }

    public function uploadImage($model, UploadedFile $file, string $collection = 'default')
    {
        return $model->addMedia($file)->toMediaCollection($collection);
    }
    public function delete($model)
    {
        return $model->delete;
    }
}
