<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequests\MediaCreateRequest;
use App\Http\Requests\MediaRequests\MediaUpdateRequest;
use App\Http\Requests\MediaRequests\UploadFileRequest;
use App\Models\Dishes;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class MediaController extends Controller
{

    public function __construct(
        private MediaService $mediaService
    )
    {
    }


    /**
     * @return JsonResponse
     */
    public function getMedia(): JsonResponse
    {
        $allMedia = $this->mediaService->getAllMedia();

        return new JsonResponse($allMedia, Response::HTTP_OK);
    }

    /**
     * @param Media $media
     * @return JsonResponse
     */
    public function getMediaById(Media $media): JsonResponse
    {
        $dish = $this->mediaService->getMediaById($media);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @param UploadFileRequest $uploadFileRequest
     * @return JsonResponse
     */
    public function createMedia(User $model, Request $uploadFileRequest): JsonResponse
    {
        dd($model);
        if ($uploadFileRequest->hasFile('files')) {
            return new JsonResponse($this->mediaService->createMedias($uploadFileRequest), Response::HTTP_CREATED);
        }

        return new JsonResponse($this->mediaService->createMedia($uploadFileRequest, $model), Response::HTTP_CREATED);

    }

    /**
     * @param Media $media
     * @param Request $mediaUpdateRequest
     * @return JsonResponse
     */
    public function updateMedia(Media $media, Request $mediaUpdateRequest): JsonResponse
    {
        return new JsonResponse($this->mediaService->updateMedia($media, $mediaUpdateRequest), Response::HTTP_OK);
    }

    /**
     * @param Media $media
     * @return JsonResponse
     */
    public function deleteMedia(Media $media): JsonResponse
    {
        $response = $this->mediaService->deleteMedia($media);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}
