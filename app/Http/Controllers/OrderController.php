<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreate\OrderCreateRequest;
use App\Http\Requests\OrderCreate\OrderUpdateRequest;
use App\Models\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    )
    {
    }


    /**
     *  @OA\Get(
     *      path="/api/orders",
     *      summary="Get a list of orders",
     *      tags={"Orders"},
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=1
     *          ),
     *          description="Page number"
     *      ),
     *      @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              example=3
     *          ),
     *          description="Number of elements on page"
     *      ),
     *      @OA\Parameter(
     *            name="id",
     *            in="query",
     *            required=false,
     *            @OA\Schema(
     *                type="integer",
     *                example="18"
     *            ),
     *            description="Filter by id"
     *        ),
     *      @OA\Parameter(
     *          name="payment_method",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="cash"
     *          ),
     *          description="Filter by payment_method"
     *      ),
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
     *                          property="status",
     *                          type="string",
     *                          example="1"
     *                      ),
     *                      @OA\Property(
     *                          property="total_price",
     *                          type="string",
     *                          example="700"
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
     *                           property="user_id",
     *                           type="integer",
     *                           example=3
     *                       ),
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
    public function getOrders(): JsonResponse
    {
        $queryParams = request()->query();
        $orders = $this->orderService->getAllOrders($queryParams);

        return new JsonResponse($orders, Response::HTTP_OK);
    }


    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     operationId="getOrderByID",
     *     tags={"Orders"},
     *     summary="Get a specific order",
     *     description="Returns order data",
     *     @OA\Parameter(
     *         name="id",
     *         description="User's id",
     *         required=true,
     *         in="path"
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="id",
     *                   type="integer",
     *                   example=28
     *               ),
     *               @OA\Property(
     *                   property="status",
     *                   type="string",
     *                   example="1"
     *               ),
     *               @OA\Property(
     *                   property="total_price",
     *                   type="string",
     *                   example="700"
     *                ),
     *                @OA\Property(
     *                    property="created_at",
     *                    type="string",
     *                    example="2024-08-15T08:55:40.000000Z"
     *                ),
     *                @OA\Property(
     *                    property="updated_at",
     *                    type="string",
     *                    example="2024-08-15T08:55:40.000000Z"
     *                ),
     *                @OA\Property(
     *                    property="user_id",
     *                    type="integer",
     *                    example=3
     *                ),
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
     * @param Order $order
     * @return JsonResponse
     *
     */
    public function getOrder(Order $order): JsonResponse
    {
        $order = $this->orderService->getOrderById($order);

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     operationId="createOrder",
     *     tags={"Orders"},
     *     summary="Create new Order",
     *     description="Returns Order data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="payment_method",
     *                 type="string",
     *                 example="cash"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                  property="total_price",
     *                  type="boolean",
     *                  example=1000
     *             ),
     *             @OA\Property(
     *                   property="orders",
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
     *                  property="user_id",
     *                  type="integer",
     *                  example=3
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                   property="total_price",
     *                   type="integer",
     *                   example=600
     *              ),
     *              @OA\Property(
     *                    property="payment_method",
     *                    type="string",
     *                    example="cash"
     *               ),
     *               @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2024-08-21T13:40:26.000000Z"
     *               ),
     *               @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2024-08-21T13:40:26.000000Z"
     *               ),
     *               @OA\Property(
     *                   property="id",
     *                   type="integer",
     *                   example=36
     *               ),
     *              @OA\Property(
     *                    property="dishes",
     *                    type="array",
     *                    @OA\Items(
     *                        type="object",
     *                        @OA\Property(
     *                            property="id",
     *                            type="integer",
     *                            example=1
     *                        ),
     *                        @OA\Property(
     *                            property="title",
     *                            type="string",
     *                            example="Borsch"
     *                        ),
     *                        @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="Very tasty"
     *                        ),
     *                        @OA\Property(
     *                             property="price",
     *                             type="integer",
     *                             example=100
     *                        ),
     *                        @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2024-08-21T13:40:26.000000Z"
     *                        ),
     *                        @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2024-08-21T13:40:26.000000Z"
     *                        ),
     *                        @OA\Property(
     *                             property="order_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                    ),
     *                    example={
     * "id": 1,
     * "title": "Borsch",
     * "description": "Very tasty",
     * "price": 100,
     * "created_at": "2024-08-15T07:02:21.000000Z",
     * "updated_at": "2024-08-15T07:02:21.000000Z",
     * "order_id": 1,
     * },
     *              ),
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
     * @param OrderCreateRequest $orderCreateRequest
     * @return JsonResponse
     *
     */
    public function createOrder(OrderCreateRequest $orderCreateRequest): JsonResponse
    {


        $data = $orderCreateRequest->getContent();
        $content = json_decode($data, true);



        $order = $this->orderService->createOrder($content);

        $paymentController = new PaymentController();

        $paymentController->createPayment($order);



        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/api/orders/update/{id}",
     *     operationId="updateOrderById",
     *     tags={"Orders"},
     *     summary="update order by id",
     *     description="Returns Order data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="payment_method",
     *                 type="string",
     *                 example="cash"
     *             ),
     *             @OA\Property(
     *                  property="total_price",
     *                  type="boolean",
     *                  example=1000
     *             ),
     *             @OA\Property(
     *                   property="dishes",
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
     *                  property="user_id",
     *                  type="integer",
     *                  example=3
     *              ),
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                   property="total_price",
     *                   type="integer",
     *                   example=600
     *              ),
     *              @OA\Property(
     *                    property="payment_method",
     *                    type="string",
     *                    example="cash"
     *               ),
     *               @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     example="2024-08-21T13:40:26.000000Z"
     *               ),
     *               @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     example="2024-08-21T13:40:26.000000Z"
     *               ),
     *               @OA\Property(
     *                   property="id",
     *                   type="integer",
     *                   example=36
     *               ),
     *              @OA\Property(
     *                    property="dishes",
     *                    type="array",
     *                    @OA\Items(
     *                        type="object",
     *                        @OA\Property(
     *                            property="id",
     *                            type="integer",
     *                            example=1
     *                        ),
     *                        @OA\Property(
     *                            property="title",
     *                            type="string",
     *                            example="Borsch"
     *                        ),
     *                        @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             example="Very tasty"
     *                        ),
     *                        @OA\Property(
     *                             property="price",
     *                             type="integer",
     *                             example=100
     *                        ),
     *                        @OA\Property(
     *                             property="updated_at",
     *                             type="string",
     *                             example="2024-08-21T13:40:26.000000Z"
     *                        ),
     *                        @OA\Property(
     *                             property="created_at",
     *                             type="string",
     *                             example="2024-08-21T13:40:26.000000Z"
     *                        ),
     *                        @OA\Property(
     *                             property="order_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                    ),
     *                    example={
     * "id": 1,
     * "title": "Borsch",
     * "description": "Very tasty",
     * "price": 100,
     * "created_at": "2024-08-15T07:02:21.000000Z",
     * "updated_at": "2024-08-15T07:02:21.000000Z",
     * "order_id": 1,
     * },
     *              ),
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
     * @param Order $order
     * @param OrderUpdateRequest $orderUpdateRequest
     * @return JsonResponse
     *
     */
    public function updateOrder(Order $order, OrderUpdateRequest $orderUpdateRequest): JsonResponse
    {
        $data = $orderUpdateRequest->getContent();
        $content = json_decode($data, true);

        $order = $this->orderService->updateOrder($order, $content);

        return new JsonResponse($order, Response::HTTP_OK);

    }


    /**
     *  @OA\Delete(
     *  path="/api/orders/delete/{id}",
     *  operationId="deleteOrder",
     *  tags={"Orders"},
     *  summary="Delete the Order",
     *  description="Returns response",
     *      @OA\Parameter(
     *          name="id",
     *          description="Order's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Order was removed"
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
     * @param Order $order
     * @return JsonResponse
     */
    public function deleteOrder(Order $order): JsonResponse
    {
        $response = $this->orderService->deleteOrder($order);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}
