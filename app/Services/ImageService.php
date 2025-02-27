<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class ImageService
{
    public function uploadImage($item_model, UploadedFile $file)
    {
        $name = uniqid() . '-' . Str::random(8) . "-{$item_model->getTable()}-{$item_model->slug}";
        $filename = "{$name}.{$file->getClientOriginalExtension()}";

        return $item_model->addMedia($file)
            ->usingFileName($filename)
            ->withCustomProperties(['name' => $name])
            ->toMediaCollection();
    }

    public function getFirstImage($item_model)
    {
        return $item_model->getFirstMedia();
    }

    public function getImages($item_model, array $filters = [])
    {
        return $item_model->getMedia(filters: $filters);
    }

    public function getSpecificImage($item_model, string $name)
    {
        return $this->getImages($item_model, ['name' => $name])->first();
    }

    public function delete(Media $media): bool|null
    {
        return $media->delete();
    }

    public function deleteAllMedia($item_model)
    {
        return $item_model->clearMediaCollection();
    }
}
