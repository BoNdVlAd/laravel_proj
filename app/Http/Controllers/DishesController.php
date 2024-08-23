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
     *  @OA\Get(
     *      path="/api/dishes",
     *      summary="Get a list of dihes",
     *      tags={"Dishes"},
     *      @OA\Parameter(
     *           name="page",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer",
     *               example=1
     *           ),
     *           description="Page number"
     *       ),
     *       @OA\Parameter(
     *           name="perPage",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer",
     *               example=3
     *           ),
     *           description="NUmber of elements on page"
     *       ),
     *       @OA\Parameter(
     *             name="title",
     *             in="query",
     *             required=false,
     *             @OA\Schema(
     *                 type="string",
     *                 example="Borsch"
     *             ),
     *             description="Filter by title"
     *         ),
     *       @OA\Parameter(
     *           name="description",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="string",
     *               example="Very tasty"
     *           ),
     *           description="Filter by description"
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="title",
     *                          type="string",
     *                          example="Borsch"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string",
     *                          example="Very tasty"
     *                      ),
     *                      @OA\Property(
     *                         property="price",
     *                         type="integer",
     *                         example="Very tasty"
     *                      ),
     *                      @OA\Property(
     *                          property="recipe",
     *                          type="array",
     *                          @OA\Items(
     *                              type="object",
     *                              @OA\Property(
     *                                  property="id",
     *                                  type="integer",
     *                                  example=1
     *                              ),
     *                              @OA\Property(
     *                                  property="qty",
     *                                  type="integer",
     *                                  example=5
     *                              )
     *                          ),
     *                          example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          example="2024-08-15T08:55:40.000000Z"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          example="2024-08-15T08:55:40.000000Z"
     *                      ),
     *                      @OA\Property(
     *                          property="order_id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                  )
     *               ),
     *               @OA\Property(
     *                  property="pagintaion",
     *                  type="object",
     *                  @OA\Property(
     *                      property="total",
     *                      type="integer",
     *                      example=23
     *                  ),
     *                  @OA\Property(
     *                       property="perPage",
     *                       type="integer",
     *                       example=10
     *                  ),
     *                  @OA\Property(
     *                       property="currentPage",
     *                       type="integer",
     *                       example=1
     *                  ),
     *                  @OA\Property(
     *                       property="lastPage",
     *                       type="integer",
     *                       example=3
     *                   ),
     *                   @OA\Property(
     *                        property="from",
     *                        type="integer",
     *                        example=1
     *                   ),
     *                   @OA\Property(
     *                        property="to",
     *                        type="integer",
     *                        example=10
     *                   ),
     *               ),
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
    public function getDishes(): JsonResponse
    {
        $queryParams = request()->query();
        $dishes = $this->dishesService->getAllDishes($queryParams);


        return new JsonResponse($dishes, Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/dishes/{id}",
     *     operationId="getDishesByID",
     *     tags={"Dishes"},
     *     summary="Get a specific dishes",
     *     description="Returns dishes data",
     *     @OA\Parameter(
     *         name="id",
     *         description="Dishes's id",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="id",
     *                  type="integer",
     *                  example=1
     *               ),
     *               @OA\Property(
     *                  title="title",
     *                  type="string",
     *                  example="Borsch"
     *               ),
     *               @OA\Property(
     *                  property="description",
     *                  type="string",
     *                  example="Very tasty"
     *               ),
     *               @OA\Property(
     *                  property="price",
     *                  type="string",
     *                  example="100"
     *               ),
     *               @OA\Property(
     *                  property="recipe",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example=1
     *                      ),
     *                      @OA\Property(
     *                          property="qty",
     *                          type="integer",
     *                          example=5
     *                      )
     *                  ),
     *                  example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *               ),
     *               @OA\Property(
     *                  property="created_at",
     *                  type="string",
     *                  example="2024-08-15T08:55:40.000000Z"
     *               ),
     *               @OA\Property(
     *                  property="updated_at",
     *                  type="string",
     *                  example="2024-08-15T08:55:40.000000Z"
     *               ),
     *               @OA\Property(
     *                  property="order_id",
     *                  type="integer",
     *                  example=1
     *               ),
     *           )
     *       ),
     *       @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *       ),
     *       @OA\Response(
     *           response=500,
     *           description="Internal server error"
     *       )
     * )
     *
     * @param Dishes $dishes
     * @return JsonResponse
     *
     */
    public function getDish(Dishes $dishes): JsonResponse
    {
        $dish = $this->dishesService->getDishesById($dishes);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/dishes",
     *     operationId="createDishes",
     *     tags={"Dishes"},
     *     summary="Create new Dishes",
     *     description="Returns dishes data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Dumpling Craft"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Dumplings are a broad class of dishes that consist of pieces of dough wrapped around a filling, or of dough with no filling."
     *             ),
     *             @OA\Property(
     *                   property="recipe",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(
     *                           property="id",
     *                           type="integer",
     *                           example=1
     *                       ),
     *                       @OA\Property(
     *                           property="qty",
     *                           type="integer",
     *                           example=5
     *                       )
     *                   ),
     *                   example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 example=100
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  example="Dumpling Craft"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string",
     *                  example="Dumplings are a broad class of dishes that consist of pieces of dough wrapped around a filling, or of dough with no filling."
     *              ),
     *              @OA\Property(
     *                   property="price",
     *                   type="integer",
     *                   example=100
     *              ),
     *              @OA\Property(
     *                    property="recipe",
     *                    type="array",
     *                    @OA\Items(
     *                        type="object",
     *                        @OA\Property(
     *                            property="id",
     *                            type="integer",
     *                            example=1
     *                        ),
     *                        @OA\Property(
     *                            property="qty",
     *                            type="integer",
     *                            example=5
     *                        )
     *                    ),
     *                    example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *              ),
     *              @OA\Property(
     *                    property="updated_at",
     *                    type="string",
     *                    example="2024-08-21T13:40:26.000000Z"
     *              ),
     *              @OA\Property(
     *                    property="created_at",
     *                    type="string",
     *                    example="2024-08-21T13:40:26.000000Z"
     *              ),
     *              @OA\Property(
     *                    property="id",
     *                    type="integer",
     *                    example=22
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
     * @param DishesCreateRequest $dishesCreateRequest
     * @return JsonResponse
     *
     */
    public function createDish(DishesCreateRequest $dishesCreateRequest): JsonResponse
    {
        $data = $dishesCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->createDishes($content);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/api/dishes/update/{id}",
     *     operationId="updateDishes",
     *     tags={"Dishes"},
     *     summary="Update the Dishes",
     *     description="Returns dishes data",
     *     @OA\Parameter(
     *          name="id",
     *          description="Dishes's id",
     *          required=true,
     *          in="path"
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Dumpling Craft"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Dumplings are a broad class of dishes that consist of pieces of dough wrapped around a filling, or of dough with no filling."
     *             ),
     *             @OA\Property(
     *                   property="recipe",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       @OA\Property(
     *                           property="id",
     *                           type="integer",
     *                           example=1
     *                       ),
     *                       @OA\Property(
     *                           property="qty",
     *                           type="integer",
     *                           example=5
     *                       )
     *                   ),
     *                   example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 example=100
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                   property="id",
     *                   type="integer",
     *                   example=1
     *               ),
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  example="Dumpling Craft"
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  type="string",
     *                  example="Dumplings are a broad class of dishes that consist of pieces of dough wrapped around a filling, or of dough with no filling."
     *              ),
     *              @OA\Property(
     *                   property="price",
     *                   type="integer",
     *                   example=100
     *              ),
     *              @OA\Property(
     *                    property="recipe",
     *                    type="array",
     *                    @OA\Items(
     *                        type="object",
     *                        @OA\Property(
     *                            property="id",
     *                            type="integer",
     *                            example=1
     *                        ),
     *                        @OA\Property(
     *                            property="qty",
     *                            type="integer",
     *                            example=5
     *                        )
     *                    ),
     *                    example={{"id": 1, "qty": 5}, {"id": 2, "qty": 3}}
     *              ),
     *              @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2024-08-21T13:40:26.000000Z"
     *               ),
     *              @OA\Property(
     *                    property="updated_at",
     *                    type="string",
     *                    example="2024-08-21T13:40:26.000000Z"
     *              ),
     *
     *              @OA\Property(
     *                    property="order_id",
     *                    type="integer",
     *                    example=1
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
     * @param Dishes $dishes
     * @param DishesUpdateRequest $dishesUpdateRequest
     * @return JsonResponse
     *
     */
    public function updateDish(Dishes $dishes, DishesUpdateRequest $dishesUpdateRequest): JsonResponse
    {
        $data = $dishesUpdateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->updateDishes($dishes, $content);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     *  @OA\Delete(
     *  path="/api/dishes/delete/{id}",
     *  operationId="deleteDishes",
     *  tags={"Dishes"},
     *  summary="Delete the Dishes",
     *  description="Returns response",
     *      @OA\Parameter(
     *          name="id",
     *          description="Dishes's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Dish was removed"
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
     * @param Dishes $dish
     * @return JsonResponse
     */
    public function deleteDish(Dishes $dish): JsonResponse
    {
        $response = $this->dishesService->deleteDishes($dish);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/dishes/addDishToOrder/{id}",
     *     operationId="addDishToOrder",
     *     tags={"Dishes"},
     *     summary="add dishes to order",
     *     description="Returns dishes data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="Dumpling Craft"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 example="Dumplings are a broad class of dishes that consist of pieces of dough wrapped around a filling, or of dough with no filling."
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 example=100
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Dishes"
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
     *  @param DishesCreateRequest $dishesCreateRequest
     *  @param Order $order
     *  @return JsonResponse
     *
     */
    public function addDishToOrder(DishesCreateRequest $dishesCreateRequest, Order $order): JsonResponse
    {
        $data = $dishesCreateRequest->getContent();
        $content = json_decode($data, true);

        $dish = $this->dishesService->addDishToOrder($content, $order);

        return new JsonResponse($dish, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/media/dishes/{id}",
     *     operationId="createMediaForDishes",
     *     tags={"Dishes"},
     *     summary="Create Media for dishes",
     *     @OA\Parameter(
     *         name="id",
     *         description="Dishes's id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file1",
     *                     type="string",
     *                     format="binary"
     *                 ),
     *                 @OA\Property(
     *                     property="file2",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Media uploaded successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     * @param Dishes $model
     * @param Request $uploadFileRequest
     * @return JsonResponse
     *
     */
    public function createMedia(Dishes $model, Request $uploadFileRequest): JsonResponse
    {
        return new JsonResponse($this->mediaService->createMedia($model, $uploadFileRequest), Response::HTTP_CREATED);

    }

    /**
     * @OA\Get(
     *     path="/api/media/dishes/{id}",
     *     operationId="getMediaForDishes",
     *     tags={"Dishes"},
     *     summary="Get media from specific dishes",
     *     @OA\Parameter(
     *         name="id",
     *         description="Dishes's id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(
     *               type="array",
     *               @OA\Items(
     *                  ref="#/components/schemas/Media"
     *               )
     *           )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *     )
     * )
     * @param Dishes $model
     * @return JsonResponse
     *
     */
    public function getMedia(Dishes $model): JsonResponse
    {
        $allMedia = $this->mediaService->getAllMedia($model);

        return new JsonResponse($allMedia, Response::HTTP_OK);
    }
}
