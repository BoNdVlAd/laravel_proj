<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function getOrders(): JsonResponse
    {
        $orders = Order::all()->load('dishes');
        return new JsonResponse($orders, Response::HTTP_OK);
    }
}
