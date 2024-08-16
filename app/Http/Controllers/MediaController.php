<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;
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
     * @param Media $media
     * @return JsonResponse
     */
    public function getMediaById(Media $media): JsonResponse
    {
        $dish = $this->mediaService->getMediaById($media);

        return new JsonResponse($dish, Response::HTTP_OK);
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
