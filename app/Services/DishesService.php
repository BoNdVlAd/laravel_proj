<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class DishesService
{
    /**
     * @return Collection
     */
    public function getAllDishes(): Collection
    {
        return Dishes::all();
    }

    /**
     * @param $dishes
     * @return Dishes|null
     */
    public function getDishesById($dishes): ?Dishes
    {
        return $dishes;
    }

    /**
     * @param array $data
     * @return Dishes|null
     */
    public function createDishes(array $data): ?Dishes
    {
        $dish = new Dishes;
        $dish->title = $data['title'] ?? null;
        $dish->description = $data['description'] ?? null;
        $dish->price = $data['price'] ?? null;

        $dish->save();

        return $dish;
    }

    /**
     * @param $dishes
     * @param array $data
     * @return Dishes|null
     */
    public function updateDishes($dishes, array $data): ?Dishes
    {
        $dishes->title = $data['title'] ?? $dishes->title;
        $dishes->description = $data['description'] ?? $dishes->description;
        $dishes->price = $data['price'] ?? $dishes->price;

        $dishes->save();

        return $dishes;
    }

    /**
     * @param $dish
     * @return string
     */
    public function deleteDishes($dish): string
    {
        $dish->delete();
        return 'Dish was removed';
    }

    /**
     * @param $data
     * @param $order
     * @return Dishes|string
     */
    public function addDishToOrder($data, $order): Dishes|string
    {
        if($order->status){
            return 'Order was already processed';
        }
        $dish = new Dishes;
        $dish->title = $data['title'] ?? null;
        $dish->description = $data['description'] ?? null;
        $dish->price = $data['price'] ?? null;
        $order->dishes()->save($dish);
        $order->calculateTotalPrice();

        return $dish;
    }
}
