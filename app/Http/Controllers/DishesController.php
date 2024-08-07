<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishesRequests\DishesCreate;
use App\Http\Requests\DishesRequests\DishesUpdate;
use App\Models\Dishes;
use App\Services\DishesService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DishesController extends Controller
{
    public function __construct(
        private DishesService $dishesService
    )
    {
    }

    /**
     * @return JsonResponse
     */
    public function getDishes(): JsonResponse
    {
        $dishes = $this->dishesService->getAllDishes();

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
     * @param DishesCreate $dishesCreateRequest
     * @return JsonResponse
     */
    public function createDish(DishesCreate $dishesCreateRequest): JsonResponse
    {
        $data = $dishesCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->createDishes($content);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @param Dishes $dishes
     * @param DishesUpdate $dishesUpdateRequest
     * @return JsonResponse
     */
    public function updateDish(Dishes $dishes, DishesUpdate $dishesUpdateRequest): JsonResponse
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
}
