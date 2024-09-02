<?php

namespace App\Services;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\PagintaionHelper;

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

    public function updateMenu($menu, array $data): Collection
    {
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
     * @param Menu $menu
     * @return Collection
     */
    public function getMenu($menu): Collection
    {
        if ($menu->dishes) {
            return $menu->dishes;
        }
        abort(404,'This restaurant doesnt have menu');
    }

    /**
     * @param $queryParams
     * @return array
     */
    public function getAllMenu($queryParams): array
    {
        $menu =  Menu::query();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($menu, $showPerPage, $queryParams);

        return $paginated;
    }
}
