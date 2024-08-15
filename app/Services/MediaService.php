<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\Media;
use http\Client\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @param $files
     * @return mixed
     */
    public function createMedias($files)
    {
        $user = auth()->user();

        $gallery = $user->gallery()->firstOrCreate();

        foreach ($files->file('files') as $key => $file) {
            if ($file->isValid()) {
                $filePath = $file->store('uploads', 'public');
                $gallery->media()->create([
                    'filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'url' => Storage::url($filePath)
                ]);
            } else {
                abort(400, "Media upload failed");
            }
        }
        return $gallery->media;
    }

    /**
     * @param $file
     * @return Media|null
     */
    public function createMedia($file): ?Media
    {

        if ($file->file('file')->isValid()) {

            $filePath = $file->file('file')->store('uploads', 'public');

            $user = auth()->user();

            $gallery = $user->gallery()->firstOrCreate();

            $media = $gallery->media()->create([
                'filename' => $file->file('file')->getClientOriginalName(),
                'mime_type' => $file->file('file')->getMimeType(),
                'size' => $file->file('file')->getSize(),
                'url' => Storage::url($filePath)
            ]);

            return $media;
        }
        abort(400, "Media upload failed");
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
