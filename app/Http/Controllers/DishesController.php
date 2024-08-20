<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishesRequests\DishesCreateRequest;
use App\Http\Requests\DishesRequests\DishesUpdateRequest;
use App\Models\Dishes;
use App\Models\Order;
use App\Services\DishesService;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DishesController
{
    public function __construct(
        private DishesService $dishesService,
        private MediaService $mediaService
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function getDishes(): JsonResponse
    {
        $queryParams = request()->query();
        $dishes = $this->dishesService->getAllDishes($queryParams);


        return new JsonResponse($dishes, Response::HTTP_OK);

    }

    /**
     * @param Dishes $dishes
     * @return JsonResponse
     */
    public function getDish(Dishes $dishes): JsonResponse
    {
        $dish = $this->dishesService->getDishesById($dishes);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @param DishesCreateRequest $dishesCreateRequest
     * @return JsonResponse
     */
    public function createDish(DishesCreateRequest $dishesCreateRequest): JsonResponse
    {
        $data = $dishesCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->createDishes($content);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @param Dishes $dishes
     * @param DishesUpdateRequest $dishesUpdateRequest
     * @return JsonResponse
     */
    public function updateDish(Dishes $dishes, DishesUpdateRequest $dishesUpdateRequest): JsonResponse
    {
        $data = $dishesUpdateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->updateDishes($dishes, $content);

        return new JsonResponse($dish, Response::HTTP_OK);

    }

    /**
     * @param Dishes $dish
     * @return JsonResponse
     */
    public function deleteDish(Dishes $dish): JsonResponse
    {
        $response = $this->dishesService->deleteDishes($dish);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

    /**
     * @param DishesCreateRequest $dishesCreateRequest
     * @param Order $order
     * @return JsonResponse
     */
    public function addDishToOrder(DishesCreateRequest $dishesCreateRequest, Order $order): JsonResponse
    {
        $data = $dishesCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->addDishToOrder($content, $order);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @param Dishes $model
     * @param Request $uploadFileRequest
     * @return JsonResponse
     */
    public function createMedia(Dishes $model, Request $uploadFileRequest): JsonResponse
    {
        return new JsonResponse($this->mediaService->createMedia($model, $uploadFileRequest), Response::HTTP_CREATED);

    }

    /**
     * @param Dishes $model
     * @return JsonResponse
     */
    public function getMedia(Dishes $model): JsonResponse
    {
        $allMedia = $this->mediaService->getAllMedia($model);

        return new JsonResponse($allMedia, Response::HTTP_OK);
    }
}
