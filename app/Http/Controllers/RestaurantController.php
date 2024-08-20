<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequests\RestaurantCreateRequest;
use App\Http\Requests\RestaurantRequests\RestaurantGetTheNearestRequest;
use App\Http\Requests\RestaurantRequests\RestaurantUpdateRequest;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RestaurantController extends Controller
{
    public function __construct(
        private RestaurantService $restaurantService,
    )
    {}

    /**
     * @return JsonResponse
     */
    public function getRestaurants(): JsonResponse
    {
        $restaurants = $this->restaurantService->getAllRestaurants();

        return new JsonResponse($restaurants, Response::HTTP_OK);
    }

    /**
     * @param RestaurantCreateRequest $restaurantCreateRequest
     * @return JsonResponse
     */
    public function createRestaurant(RestaurantCreateRequest $restaurantCreateRequest): JsonResponse
    {
        $data = $restaurantCreateRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->createRestaurant($content), Response::HTTP_CREATED);
    }

    /**
     * @param RestaurantGetTheNearestRequest $request
     * @return JsonResponse
     */
    public function getNearestRestaurant(RestaurantGetTheNearestRequest $request): JsonResponse
    {
        $data = $request->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->getNearestRestaurant($content), Response::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function updateRestaurant(Restaurant $restaurant, RestaurantUpdateRequest $restaurantUpdateRequest): JsonResponse
    {
        $data = $restaurantUpdateRequest->getContent();
        $content = json_decode($data, true);

        $restaurant = $this->restaurantService->updateRestaurant($restaurant, $content);

        return new JsonResponse($restaurant, Response::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function deleteRestaurant(Restaurant $restaurant): JsonResponse
    {
        $response = $this->restaurantService->deleteRestaurant($restaurant);

        return new JsonResponse(['response' => $response], 202);
    }
}


