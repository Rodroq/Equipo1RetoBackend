<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;

final class ImageService
{

    protected $disk;

    public function __construct(string $disk)
    {
        $this->disk = $disk;
    }

    public function uploadImage($model, UploadedFile $file)
    {
        $filename = "{$model->getTable()}-{$model->slug}." . $file->getClientOriginalExtension();
        $collection = "{$model->getTable()}-{$model->slug}-images";

        $media = $model->addMediaFromRequest('image')
            ->usingFileName($filename)
            ->toMediaCollection($collection, $this->disk);

        return $media;
    }

    public function getImages($model, string $collection = 'default')
    {
        return $model->getFirstMedia($collection);
    }

    public function getImageByName($model, string $filename, string $collection = 'default')
    {

        return $model->getMedia($collection)->firstWhere('file_name', $filename);
    }

    public function delete(Media $media)
    {
        return $media->delete();
    }
}
