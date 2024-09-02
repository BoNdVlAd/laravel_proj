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
     *      path="/api/menu/{id}",
     *      summary="Get specific menu",
     *      tags={"Menu"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Menu's id",
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
     * @param Menu $menu
     * @return JsonResponse
     */
    public function getMenu(Menu $menu): JsonResponse
    {
        $allMenu = $this->menuService->getMenu($menu);

        return new JsonResponse($allMenu, Response::HTTP_OK);
    }

    /**
     *  @OA\Get(
     *      path="/api/menu",
     *      summary="Get all menu",
     *      tags={"Menu"},
     *     @OA\Parameter(
     *           name="page",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer",
     *               example=1
     *           ),
     *           description="Page number"
     *       ),
     *       @OA\Parameter(
     *           name="perPage",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer",
     *               example=3
     *           ),
     *           description="Number of elements on page"
     *       ),
     *       @OA\Parameter(
     *             name="id",
     *             in="query",
     *             required=false,
     *             @OA\Schema(
     *                 type="integer",
     *                 example="18"
     *             ),
     *             description="Filter by id"
     *         ),
     *       @OA\Parameter(
     *              name="restaurant_id",
     *              in="query",
     *              required=false,
     *              @OA\Schema(
     *                  type="integer",
     *                  example="18"
     *              ),
     *              description="Filter by restaurant_id"
     *          ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                   property="data",
     *                   type="array",
     *                   @OA\Items(
     *                       type="object",
     *                       ref="#/components/schemas/Menu"
     *                   )
     *                ),
     *               @OA\Property(
     *                     property="pagintaion",
     *                     type="object",
     *                     ref="#/components/schemas/Pagination"
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
     * @param Menu $menu
     * @return JsonResponse
     */
    public function getAllMenu(): JsonResponse
    {
        $queryParams = request()->query();
        $menu = $this->menuService->getAllMenu($queryParams);

        return new JsonResponse($menu, Response::HTTP_OK);
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
     *  @OA\Patch(
     *      path="/api/menu/{id}",
     *      summary="Update menu",
     *      tags={"Menu"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Menu's id",
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
     * @param Menu $menu
     * @param MenuCreateRequest $menuCreateRequest
     * @return JsonResponse
     */
    public function updateMenu(Menu $menu, MenuCreateRequest $menuCreateRequest): JsonResponse
    {
        $data = $menuCreateRequest->getContent();
        $content = json_decode($data, true);

        $menu = $this->menuService->updateMenu($menu, $content);

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


