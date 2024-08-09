<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MediaService
{
    /**
     * @return Collection
     */
    public function getAllMedia(): Collection
    {
        return Media::all();
    }

    /**
     * @param $media
     * @return Dishes|null
     */
    public function getMediaById($media): ?Media
    {
        return $media;
    }

    /**
     * @param array $data
     * @return Media|null
     */
    public function createMedia(array $data): ?Media
    {
        $user = auth()->user();
        $gallery = $user->gallery()->firstOrCreate();
        $media = $gallery->media()->create([
            'filename' => $data['filename'] ?? null,
            'mime_type' => $data['mime_type'] ?? null,
            'size' => $data['size'] ?? null,
            'url' => $data['url'] ?? null,
        ]);
        return $media;
    }

    /**
     * @param $media
     * @param array $data
     * @return Media|null
     */
    public function updateMedia($media, array $data): ?Media
    {
        $media->filename = $data['filename'] ?? $media->filename;
        $media->mime_type = $data['mime_type'] ?? $media->mime_type;
        $media->size = $data['size'] ?? $media->size;
        $media->url = $data['url'] ?? $media->url;

        $media->save();

        return $media;
    }

    /**
     * @param $dish
     * @return string
     */
    public function deleteMedia($media): string
    {
        $media->delete();
        return 'Dish was removed';
    }

}
