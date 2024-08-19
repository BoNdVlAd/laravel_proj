<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

class RestaurantService
{
    /**
     * @return Collection
     */
    public function getAllRestaurants(): Collection
    {
        return Restaurant::all();
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

    /**
     * @param Restaurant $restaurant
     * @return Menu
     */
    public function getMenu(Restaurant $restaurant): Menu
    {
        return $restaurant->menu()->first();
    }
}
