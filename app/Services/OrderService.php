<?php

namespace App\Services;

use App\Helpers\PagintaionHelper;
use App\Models\Dishes;
use App\Models\Order;

class OrderService
{
    /**
     * @param $queryParams
     * @return array
     */
    public function getAllOrders($queryParams): array
    {
        $orders =  Order::query();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($orders, $showPerPage, $queryParams);

        foreach ($paginated['data'] as $order) {
            $order['dishes'] = $order->dishes;
        }

        return $paginated;
    }

    /**
     * @param $order
     * @return Order|null
     */
    public function getOrderById($order): array
    {

        return [
            "order"=> $order,
            "dishes"=> $order->dishes
        ];

    }

    /**
     * @param array $data
     * @return Order|null
     */
    public function createOrder(array $data): ?Order
    {
        $order = new Order();

        $order->user_id = auth()->id();
        $order->status = $data['status'] ?? null;
        $order->total_price = $data['total_price'] ?? 0;
        $order->payment_method = $data['payment_method'] ?? null;

        $order->save();

        foreach ($data['dishes'] as $dishData) {
            $dish = Dishes::find($dishData['id']);
            for ($i = 0; $i < $dishData['qty']; $i++) {
                $order->dishes()->attach($dish);
            }
        }

        $order->calculateTotalPrice();

        $order->save();

        return $order;
    }

    /**
     * @param $order
     * @param array $data
     * @return Order|null
     */
    public function updateOrder($order, $data): ?Order
    {
        if ($order->status) {
            abort(400, "Order was already processed");
        }
        $order->payment_method = $data['payment_method'] ?? null;
        $order->total_price = $data['total_price'] ?? null;
        $order->user_id = auth()->id();

        $order->save();

        $order->dishes()->detach();

        foreach ($data['dishes'] as $dishData) {
            $dish = Dishes::find($dishData['id']);
            for ($i = 0; $i < $dishData['qty']; $i++) {
                $order->dishes()->attach($dish);
            }
        }

        $order->calculateTotalPrice();

        return $order;
    }

    /**
     * @param $order
     * @return string
     */
    public function deleteOrder($order): string
    {
        $order->delete();

        return 'Order was removed';
    }
}
