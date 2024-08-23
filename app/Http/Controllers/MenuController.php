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
     *  @OA\Get(
     *      path="/api/menu/restaurants/{id}",
     *      summary="Get menu for specific restaurant",
     *      tags={"Menu"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Restaurant's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                      @OA\Items(ref="#/components/schemas/Dishes")
     *               ),
     *               ),
     *           )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getMenu(Restaurant $restaurant): JsonResponse
    {
        $allMenu = $this->menuService->getMenu($restaurant);

        return new JsonResponse(['data'=>$allMenu], Response::HTTP_OK);
    }

    /**
     *  @OA\Post(
     *      path="/api/menu/restaurant/{id}",
     *      summary="Create menu for a specific restaurant",
     *      tags={"Menu"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Restaurant's id",
     *          required=true,
     *          in="path"
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="dishes",
     *                  type="array",
     *                  @OA\Items(type="integer"),
     *                  example={1, 2}
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                      @OA\Items(ref="#/components/schemas/Dishes")
     *               ),
     *           )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     *
     *
     * @param Restaurant $restaurant
     * @param Request $menuCreateRequest
     * @return JsonResponse
     */
    public function createMenu(Restaurant $restaurant, MenuCreateRequest $menuCreateRequest): JsonResponse
    {
        $data = $menuCreateRequest->getContent();
        $content = json_decode($data, true);

        $menu = $this->menuService->createMenu($restaurant, $content);

        return new JsonResponse(['data' => $menu], Response::HTTP_CREATED);
    }

    /**
     *  @OA\Delete(
     *  path="/api/menu/delete/{id}",
     *  operationId="deleteMenu",
     *  tags={"Menu"},
     *  summary="Delete the Menu",
     *  description="Returns message about operation",
     *      @OA\Parameter(
     *          name="id",
     *          description="Menu's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Menu has been deleted"
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ivalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param Menu $menu
     * @return JsonResponse
     */
    public function deleteMenu(Menu $menu): JsonResponse
    {
        $response = $this->menuService->deleteMenu($menu);

        return new JsonResponse(['response'=>$response], 202);
    }
}


