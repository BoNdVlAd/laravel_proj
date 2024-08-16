<?php

namespace App\Services;

use App\Models\Dishes;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    /**
     * @param Restaurant $restaurant
     * @param array $data
     * @return Collection
     */
    public function createMenu(Restaurant $restaurant, array $data): Collection
    {
        $menu = $restaurant->menu()->createOrFirst(
            [
                "restaurant_id"=>$restaurant->id,
            ]
        );
        $menu->dishes()->sync($data['dishes']);
        return $menu->dishes;
    }

    /**
     * @param $user
     * @return string
     */
    public function deleteMenu($menu): string
    {
        $menu->delete();

        return 'Menu has been deleted';
    }

    /**
     * @param $role
     * @return string
     */
    public function checkRole($role): string
    {
        $user = auth()->user();
        if($user->hasRole($role)) {
            return 'true';
        }
        return 'false';
    }


    /**
     * @param $role
     * @return string
     */
    public function editRole($role): string
    {
        $user = auth()->user();
        $user->roles()->detach();
        $user->roles()->attach(Role::where('slug',$role)->first());

        return 'Role has been changed';
    }

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
    public function getMenu(Restaurant $restaurant): Collection
    {

        return $restaurant->menu->dishes;
    }
}
