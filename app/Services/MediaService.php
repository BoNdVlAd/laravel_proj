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
    public function getAllMedia($model): Collection
    {
        return $model->gallery->media;
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
     * @param $file
     * @return Media|null
     */
    public function createMedia($model, $file): string
    {
        if ($file->hasFile('files')) {
            $gallery = $model->gallery()->firstOrCreate();

            foreach ($file->file('files') as $key => $file) {
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
            return "Media uploaded successfully";
        }

        if ($file->file('file')->isValid()) {

            $filePath = $file->file('file')->store('uploads', 'public');

            $gallery = $model->gallery()->firstOrCreate();

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
    public function updateMedia($media, $file): ?Media
    {
        if ($file->file('file')->isValid()) {
            $filePath = $file->file('file')->store('uploads', 'public');

            $media->filename = $file->file('file')->getClientOriginalName();
            $media->mime_type = $file->file('file')->getMimeType();
            $media->size = $file->file('file')->getSize();
            $media->url = Storage::url($filePath);

            $media->save();

            return $media;
        }
        abort(400, "Media upload failed");
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
