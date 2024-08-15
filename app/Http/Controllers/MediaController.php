<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequests\MediaCreateRequest;
use App\Http\Requests\MediaRequests\MediaUpdateRequest;
use App\Http\Requests\MediaRequests\UploadFileRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

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
    public function createMedia(Request $uploadFileRequest): JsonResponse
    {
        if($uploadFileRequest->hasFile('files')) {
            return new JsonResponse($this->mediaService->createMedias($uploadFileRequest), Response::HTTP_CREATED);
        }

        return new JsonResponse($this->mediaService->createMedia($uploadFileRequest), Response::HTTP_CREATED);

    }

    /**
     * @param Media $media
     * @param MediaUpdateRequest $mediaUpdateRequest
     * @return JsonResponse
     */
    public function updateMedia(Media $media, MediaUpdateRequest $mediaUpdateRequest): JsonResponse
    {
        $data = $mediaUpdateRequest->getContent();
        $content = json_decode($data, true);

        $media = $this->mediaService->updateMedia($media, $content);

        return new JsonResponse($media, Response::HTTP_OK);

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
