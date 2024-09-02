<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * @param $model
     * @return Collection
     */
    public function getAllMedia($model): Collection
    {
        return $model->gallery->media;
    }

    /**
     * @param $model
     * @param $file
     * @return string
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

            return "Media uploaded successfully";
        }
        abort(400, "Media upload failed");
    }

    /**
     * @param $model
     * @param $media
     * @return string
     */
    public function deleteMedia($media): string
    {
        $media->delete();
        return 'Media was removed';
    }
}
