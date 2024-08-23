<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequests\ProductCreateRequest;
use App\Http\Requests\ProductRequests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    )
    {
    }

    /**
     *  @OA\Get(
     *      path="/api/products",
     *      summary="Get a list of products",
     *      tags={"Products"},
     *      @OA\Parameter(
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
     *           description="NUmber of elements on page"
     *       ),
     *       @OA\Parameter(
     *             name="title",
     *             in="query",
     *             required=false,
     *             @OA\Schema(
     *                 type="string",
     *                 example="carrot"
     *             ),
     *             description="Filter by title"
     *         ),
     *       @OA\Parameter(
     *           name="weight",
     *           in="query",
     *           required=false,
     *           @OA\Schema(
     *               type="integer",
     *               example=2
     *           ),
     *           description="Filter by weight"
     *       ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               type="object",
     *               @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Product"
     *                  )
     *               ),
     *               @OA\Property(
     *                  property="pagintaion",
     *                  type="object",
     *                  @OA\Property(
     *                      property="total",
     *                      type="integer",
     *                      example=23
     *                  ),
     *                  @OA\Property(
     *                       property="perPage",
     *                       type="integer",
     *                       example=10
     *                  ),
     *                  @OA\Property(
     *                       property="currentPage",
     *                       type="integer",
     *                       example=1
     *                  ),
     *                  @OA\Property(
     *                       property="lastPage",
     *                       type="integer",
     *                       example=3
     *                   ),
     *                   @OA\Property(
     *                        property="from",
     *                        type="integer",
     *                        example=1
     *                   ),
     *                   @OA\Property(
     *                        property="to",
     *                        type="integer",
     *                        example=10
     *                   ),
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
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $queryParams = request()->query();
        $orders = $this->productService->getAllProducts($queryParams);

        return new JsonResponse($orders, Response::HTTP_OK);
    }

    /**
     *  @OA\Post(
     *      path="/api/products/{id}",
     *      summary="get a specific product",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *           response="200",
     *           description="success",
     *           @OA\JsonContent(
     *               ref="#/components/schemas/Product"
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
     * @param Request $menuCreateRequest
     * @return JsonResponse
     */

    public function getProduct(Product $product): JsonResponse
    {
        $product = $this->productService->getProductById($product);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     operationId="createProduct",
     *     tags={"Products"},
     *     summary="Create new Product",
     *     description="Returns priduct data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="carrot"
     *             ),
     *             @OA\Property(
     *                 property="weight",
     *                 type="string",
     *                 example=2
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Product"
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param DishesCreateRequest $dishesCreateRequest
     * @return JsonResponse
     *
     */
    public function createProduct(ProductCreateRequest $productCreateRequest): JsonResponse
    {
        $data = $productCreateRequest->getContent();
        $content = json_decode($data, true);

        $product = $this->productService->createProduct($content);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @OA\Patch(
     *     path="/api/products/update/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     summary="Update the Product",
     *     description="Returns product data",
     *     @OA\Parameter(
     *          name="id",
     *          description="Dishes's id",
     *          required=true,
     *          in="path"
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 example="carrot"
     *             ),
     *             @OA\Property(
     *                 property="weight",
     *                 type="string",
     *                 example=2
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/Product"
     *          )
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Invalid input"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error"
     *      )
     *  )
     *
     * @param Dishes $dishes
     * @param DishesUpdateRequest $dishesUpdateRequest
     * @return JsonResponse
     *
     */
    public function updateProduct(Product $product, ProductUpdateRequest $orderUpdateRequest): JsonResponse
    {
        $data = $orderUpdateRequest->getContent();
        $content = json_decode($data, true);

        $product = $this->productService->updateProduct($product, $content);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     *  @OA\Delete(
     *  path="/api/products/delete/{id}",
     *  operationId="deleteProduct",
     *  tags={"Products"},
     *  summary="Delete the Product",
     *  description="Returns response",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product's id",
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product was removed"
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
     * @param Dishes $dish
     * @return JsonResponse
     */
    public function deleteProduct(Product $product): JsonResponse
    {
        $response = $this->productService->deleteProduct($product);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}
