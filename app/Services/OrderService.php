<?php

namespace App\Services;

use App\Helpers\PagintaionHelper;
use App\Models\Dishes;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * @return Collection
     */
    public function getAllOrders($queryParams): array
    {
        $orders =  Order::all();

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

        $order->payment_method = $data['payment_method'] ?? null;
        $order->status = $data['status'] ?? null;
        $order->total_price = $data['total_price'] ?? 0;
        $order->user_id = auth()->id();

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
