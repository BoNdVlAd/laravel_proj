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
     *  @OA\Get(
     *      path="/api/restaurants",
     *      summary="Get a list of restaurants",
     *      tags={"Restaurants"},
     *     @OA\Parameter(
     *            name="page",
     *            in="query",
     *            required=false,
     *            @OA\Schema(
     *                type="integer",
     *                example=1
     *            ),
     *            description="Page number"
     *        ),
     *        @OA\Parameter(
     *            name="perPage",
     *            in="query",
     *            required=false,
     *            @OA\Schema(
     *                type="integer",
     *                example=3
     *            ),
     *            description="NUmber of elements on page"
     *        ),
     *        @OA\Parameter(
     *              name="name",
     *              in="query",
     *              required=false,
     *              @OA\Schema(
     *                  type="string",
     *                  example="Asador Etxebarri"
     *              ),
     *              description="Filter by name"
     *          ),
     *        @OA\Parameter(
     *            name="country",
     *            in="query",
     *            required=false,
     *            @OA\Schema(
     *                type="string",
     *                example="France"
     *            ),
     *            description="Filter by country"
     *        ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Restaurant"
     *                  )
     *               ),
     *               @OA\Property(
     *                   property="pagintaion",
     *                   type="object",
     *                   ref="#/components/schemas/Pagination"
     *                ),
     *           )
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
     * @return JsonResponse
     */
    public function getRestaurants(): JsonResponse
    {
        $queryParams = request()->query();
        $restaurants = $this->restaurantService->getAllRestaurants($queryParams);

        return new JsonResponse($restaurants, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/restaurants",
     *     operationId="createRestaurant",
     *     tags={"Restaurants"},
     *     summary="Create new Restaurant",
     *     description="Returns Restaurant data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Diverxo"
     *             ),
     *             @OA\Property(
     *                 property="country",
     *                 type="string",
     *                 example="France"
     *             ),
     *             @OA\Property(
     *                  property="latitude",
     *                  type="number",
     *                  format="float",
     *                  example=50.59067
     *             ),
     *             @OA\Property(
     *                  property="longitude",
     *                  type="number",
     *                  format="float",
     *                  example=30.71773
     *             ),

     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Restaurant"
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param RestaurantCreateRequest $restaurantCreateRequest
     * @return JsonResponse
     *
     */
    public function createRestaurant(RestaurantCreateRequest $restaurantCreateRequest): JsonResponse
    {
        $data = $restaurantCreateRequest->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->createRestaurant($content), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/nearestRestaurant",
     *     operationId="getTheNearestRestaurant",
     *     tags={"Restaurants"},
     *     summary="Get the nearest Restaurant",
     *     description="Returns Restaurant data, distance, country",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="latitude",
     *                  type="number",
     *                  format="float",
     *                  example=50.59067
     *             ),
     *             @OA\Property(
     *                  property="longitude",
     *                  type="number",
     *                  format="float",
     *                  example=30.71773
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful response",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="restaurant",
     *                  type="object",
     *                  ref="#/components/schemas/Restaurant"
     *              ),
     *              @OA\Property(
     *                  property="distance",
     *                  type="number",
     *                  format="float",
     *                  example=20.328845035909904
     *              ),
     *              @OA\Property(
     *                  property="country",
     *                  type="string",
     *                  example="France"
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param RestaurantCreateRequest $restaurantCreateRequest
     * @return JsonResponse
     *
     */
    public function getNearestRestaurant(RestaurantGetTheNearestRequest $request): JsonResponse
    {
        $data = $request->getContent();
        $content = json_decode($data, true);

        return new JsonResponse($this->restaurantService->getNearestRestaurant($content), Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/api/restaurants/update/{id}",
     *     operationId="updateRestaurant",
     *     tags={"Restaurants"},
     *     summary="Update specific Restaurant",
     *     description="Returns Restaurant data",
     *     @OA\Parameter(
     *           name="id",
     *           description="Restaurant's id",
     *           required=true,
     *           in="path"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Diverxo"
     *             ),
     *             @OA\Property(
     *                 property="country",
     *                 type="string",
     *                 example="France"
     *             ),
     *             @OA\Property(
     *                  property="latitude",
     *                  type="number",
     *                  format="float",
     *                  example=50.59067
     *             ),
     *             @OA\Property(
     *                  property="longitude",
     *                  type="number",
     *                  format="float",
     *                  example=30.71773
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Restaurant"
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param RestaurantCreateRequest $restaurantCreateRequest
     * @return JsonResponse
     *
     */
    public function updateRestaurant(Restaurant $restaurant, RestaurantUpdateRequest $restaurantUpdateRequest): JsonResponse
    {
        $data = $restaurantUpdateRequest->getContent();
        $content = json_decode($data, true);

        $restaurant = $this->restaurantService->updateRestaurant($restaurant, $content);

        return new JsonResponse($restaurant, Response::HTTP_OK);
    }

    /**
     *  @OA\Delete(
     *  path="/api/restaurants/delete/{id}",
     *  operationId="deleteRestaurant",
     *  tags={"Restaurants"},
     *  summary="Delete the Restaurant",
     *  description="Returns message about operation",
     *      @OA\Parameter(
     *          name="id",
     *          description="Restaurant's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Restaurant was removed"
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
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function deleteRestaurant(Restaurant $restaurant): JsonResponse
    {
        $response = $this->restaurantService->deleteRestaurant($restaurant);

        return new JsonResponse(['response' => $response], 202);
    }
}


