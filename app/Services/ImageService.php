<?php

namespace App\Services;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class ImageService
{
    private string $disk;
    private string $collection;

    public function __construct(string $disk)
    {
        $this->disk = $disk;
        $this->collection = 'default';
    }

    protected function selectCollection($model): void
    {
        $this->collection = "{$model->getTable()}-{$model->slug}-images";
    }

    public function uploadImage($model, UploadedFile $file)
    {
        $this->selectCollection($model);

        $name_indetifier = now()->format('Y_m_d_His_') . Str::random(8);
        $name = "{$name_indetifier}-{$model->getTable()}-{$model->slug}";
        $filename = $name . '.' . $file->getClientOriginalExtension();

        $media = $model->addMediaFromRequest('image')
            ->usingFileName($filename)
            ->withCustomProperties(['name' => $name])
            ->toMediaCollection($this->collection, $this->disk);

        return $media;
    }

    public function getFirstImage($model)
    {
        $this->selectCollection($model);
        return $model->getFirstMedia($this->collection);
    }

    public function getImages($model, array $properties = [])
    {
        $this->selectCollection($model);
        return $model->getMedia($this->collection, $properties);
    }

    public function getImage($model, string $name)
    {
        return $this->getImages($model, ['name' => $name])->first();
    }

    public function delete(Media $media): bool|null
    {
        return $media->delete();
    }

    public function deleteAllMedia($model)
    {
        $this->selectCollection($model);
        return $model->clearMediaCollection($this->collection);
    }
}
