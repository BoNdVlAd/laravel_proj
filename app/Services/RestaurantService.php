<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\PagintaionHelper;

class RestaurantService
{
    /**
     * @param $queryParams
     * @return array
     */
    public function getAllRestaurants($queryParams): array
    {
        $query =  Restaurant::query();

        if (isset($queryParams['name'])) {
            $query->where('name', 'LIKE', "%{$queryParams['name']}%");
        }

        if (isset($queryParams['country'])) {
            $query->where('country', 'LIKE', "%{$queryParams['country']}%");
        }

        $restaurants = $query->get();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($restaurants, $showPerPage, $queryParams);

        return $paginated;
    }

    /**
     * @param array $data
     * @return Restaurant|null
     */
    public function createRestaurant(array $data): ?Restaurant
    {
        $restaurant = new Restaurant;
        $restaurant->name = $data['name'];
        $restaurant->country = $data['country'];
        $restaurant->latitude = $data['latitude'];
        $restaurant->longitude = $data['longitude'];

        $restaurant->save();

        return $restaurant;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getNearestRestaurant(array $data): array
    {
        $userCoordinates = [
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude']
        ];

        $nearestRestaurant = Restaurant::all()->sortBy(function($restaurant) use ($userCoordinates) {
            return $restaurant->calculateDistance($userCoordinates);
        })->first();

        return [
            'restaurant' => $nearestRestaurant,
            'distance' => $nearestRestaurant->calculateDistance($userCoordinates),
            'country' => $nearestRestaurant->country,
        ];
    }

    public function updateRestaurant(Restaurant $restaurant, array $data): Restaurant
    {
        $restaurant->name = $data['name'] ?? $restaurant->name;
        $restaurant->country = $data['country'] ?? $restaurant->country;
        $restaurant->latitude = $data['latitude'] ?? $restaurant->latitude;
        $restaurant->longitude = $data['longitude'] ?? $restaurant->longitude;

        $restaurant->save();

        return $restaurant;
    }

    /**
     * @param Restaurant $restaurant
     * @return string
     */
    public function deleteRestaurant(Restaurant $restaurant): string
    {
        $restaurant->delete();

        return 'restaurant was deleted';
    }
}
