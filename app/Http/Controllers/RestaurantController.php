<?php

namespace App\Http\Controllers;


use App\Http\Requests\RestaurantRequests\RestaurantCreateRequest;
use App\Models\Restaurant;
use App\Services\RestaurantService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
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
    public function getRestaurants()
    {
        $restaurants = $this->restaurantService->getAllRestaurants();

        return new JsonResponse($restaurants, Response::HTTP_OK);
    }

    public function createRestaurant(RestaurantCreateRequest $restaurantCreateRequest){
        $data = $restaurantCreateRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->createRestaurant($content), Response::HTTP_CREATED);
    }

    public function getNearestRestaurant(Request $request){
        $data = $request->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->getNearestRestaurant($content), Response::HTTP_OK);
    }

    public function getMenu(Restaurant $restaurant){
        $restaurant = $this->restaurantService->getMenu($restaurant);

        return new JsonResponse($restaurant, Response::HTTP_OK);
    }
}


