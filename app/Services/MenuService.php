<?php

namespace App\Services;

use App\Models\Restaurant;
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
        if ($restaurant->menu) {
            $restaurant->menu->delete();
        }

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
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getMenu(Restaurant $restaurant): Collection
    {
        if($restaurant->menu){
            return $restaurant->menu->dishes;
        }
        abort(404,'This restaurant doesnt have menu');
    }
}
