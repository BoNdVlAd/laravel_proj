<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequests\MediaCreateRequest;
use App\Http\Requests\MediaRequests\MediaUpdateRequest;
use App\Models\Dishes;
use App\Models\Media;
use App\Models\Order;
use App\Services\MediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @param MediaCreateRequest $mediaCreateRequest
     * @return JsonResponse
     */
    public function createMedia(MediaCreateRequest $mediaCreateRequest): JsonResponse
    {
        $data = $mediaCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->mediaService->createMedia($content);

        return new JsonResponse($dish, Response::HTTP_OK);
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
