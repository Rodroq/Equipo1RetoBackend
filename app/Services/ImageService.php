<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class ImageService
{
    public function uploadImage($item_model, UploadedFile $file, int $usuario_id, ?string $custom_name = null)
    {
        $name = $custom_name ? $custom_name : count($item_model->getMedia()) + 1 . "-{$item_model->getTable()}-{$item_model->slug}";
        $filename = "{$name}.{$file->getClientOriginalExtension()}";

        return $item_model->addMedia($file)
            ->usingFileName($filename)
            ->withCustomProperties(['name' => $name, 'usuario_id' => $usuario_id])
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

    public function getImagesUser(int $user_id)
    {
        return Media::where('custom_properties->usuario_id', $user_id)->get();
    }

    public function getSpecificImage($item_model, string $name)
    {
        return $this->getImages($item_model, ['name' => $name])->firstOrFail();
    }
}
