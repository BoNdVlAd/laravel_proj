<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequests\MenuCreateRequest;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Services\MenuService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MenuController extends Controller
{
    public function __construct(
        private MenuService $menuService,
    )
    {}

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getMenu(Restaurant $restaurant): JsonResponse
    {
        $allMenu = $this->menuService->getMenu($restaurant);

        return new JsonResponse(['data'=>$allMenu], Response::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @param Request $menuCreateRequest
     * @return JsonResponse
     */
    public function createMenu(Restaurant $restaurant, MenuCreateRequest $menuCreateRequest): JsonResponse
    {
        $data = $menuCreateRequest->getContent();
        $content = json_decode($data, true);

        $menu = $this->menuService->createMenu($restaurant, $content);

        return new JsonResponse($menu, Response::HTTP_CREATED);
    }

    /**
     * @param Menu $menu
     * @return JsonResponse
     */
    public function deleteMenu(Menu $menu): JsonResponse
    {
        $response = $this->menuService->deleteMenu($menu);

        return new JsonResponse(['response'=>$response], 202);
    }
}


