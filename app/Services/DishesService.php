<?php

namespace App\Services;

use App\Helpers\PagintaionHelper;
use App\Models\Dishes;

class DishesService
{
    /**
     * @param $queryParams
     * @return array
     */
    public function getAllDishes($queryParams): array
    {

        $query = Dishes::query();

        if (isset($queryParams['title'])) {
            $query->where('title', 'LIKE', "%{$queryParams['title']}%");
        }

        if (isset($queryParams['description'])) {
            $query->where('description', 'LIKE', "%{$queryParams['description']}%");
        }
        $dishes = $query->get();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($dishes, $showPerPage, $queryParams);

        return $paginated;
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
        $dish->recipe = $data['recipe'] ?? null;

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
        $dishes->recipe = $data['recipe'] ?? null;

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
