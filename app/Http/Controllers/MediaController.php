<?php

namespace App\Http\Controllers;

use App\Models\Media;
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
     *  @OA\Delete(
     *  path="/api/media/delete/{id}",
     *  operationId="deleteMedia",
     *  tags={"Media"},
     *  summary="Delete the Media",
     *  description="Returns response",
     *      @OA\Parameter(
     *          name="id",
     *          description="Media's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Media was removed"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param Media $media
     * @return JsonResponse
     *
     */
    public function deleteMedia(Media $media): JsonResponse
    {
        $response = $this->mediaService->deleteMedia($media);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}
