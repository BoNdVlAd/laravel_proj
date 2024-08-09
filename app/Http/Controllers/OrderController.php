<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreate\OrderCreate;
use App\Http\Requests\OrderCreateRequest\OrderCreateRequest;
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
     * @return JsonResponse
     */
    public function getOrders(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return new JsonResponse($orders, Response::HTTP_OK);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function getOrder(Order $order): JsonResponse
    {
        $order = $this->orderService->getOrderById($order);

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param OrderCreateRequest $orderCreateRequest
     * @return JsonResponse
     */
    public function createOrder(OrderCreateRequest $orderCreateRequest): JsonResponse
    {
        $data = $orderCreateRequest->getContent();
        $content = json_decode($data, true);

        $order = $this->orderService->createOrder($content);

        return new JsonResponse($order, Response::HTTP_OK);
    }

    /**
     * @param Order $order
     * @param OrderCreateRequest $orderUpdateRequest
     * @return JsonResponse
     */
    public function updateOrder(Order $order, OrderCreateRequest $orderUpdateRequest): JsonResponse
    {
        $data = $orderUpdateRequest->getContent();
        $content = json_decode($data, true);

        $order = $this->orderService->updateOrder($order, $content);

        return new JsonResponse($order, Response::HTTP_OK);

    }

    /**
     * @param Order $order
     * @return JsonResponse
     */
    public function deleteOrder(Order $order): JsonResponse
    {
        $response = $this->orderService->deleteOrder($order);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }

}
