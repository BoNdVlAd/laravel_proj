<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
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
     * @return User|null
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
     * @param $user
     * @param array $data
     * @return User|null
     */
    public function updateUser($user, array $data): ?User
    {
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->password = $data['password'] ?? $user->password;

        $user->save();

        return $user;
    }

    /**
     * @param $user
     * @return string
     */
    public function deleteUser($user): string
    {
        $user->delete();

        return 'User has been deleted';
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
    public function getMenu(Restaurant $restaurant): Menu
    {
        return $restaurant->menu()->first();
    }
}
