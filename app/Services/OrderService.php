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
        $query =  Order::query();

        if (isset($queryParams['id'])) {
            $query->where('id', 'LIKE', "%{$queryParams['id']}%");
        }

        if (isset($queryParams['payment_method'])) {
            $query->where('payment_method', 'LIKE', "%{$queryParams['payment_method']}%");
        }

        $orders = $query->get();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($orders, $showPerPage, $queryParams);

        return $paginated;
    }

    /**
     * @param $order
     * @return Order|null
     */
    public function getOrderById($order): ?Order
    {
        return $order;
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
    public function updateOrder($order, array $data): ?Order
    {
        $order->payment_method = $data['payment_method'] ?? null;
        $order->total_price = $data['total_price'] ?? null;
        $order->user_id = auth()->id();

        $order->save();

        $order->dishes()->detach();

        $order->dishes()->attach($data['dishes']);
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
