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
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $orders = $this->productService->getAllProducts();
        return new JsonResponse($orders, Response::HTTP_OK);
    }

    /**
     * @param Product $order
     * @return JsonResponse
     */
    public function getProduct(Product $product): JsonResponse
    {
        $product = $this->productService->getProductById($product);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @param ProductCreateRequest $productCreateRequest
     * @return JsonResponse
     */
    public function createProduct(ProductCreateRequest $productCreateRequest): JsonResponse
    {
        $data = $productCreateRequest->getContent();
        $content = json_decode($data, true);

        $product = $this->productService->createProduct($content);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @param Product $product
     * @param ProductUpdateRequest $orderUpdateRequest
     * @return JsonResponse
     */
    public function updateProduct(Product $product, ProductUpdateRequest $orderUpdateRequest): JsonResponse
    {
        $data = $orderUpdateRequest->getContent();
        $content = json_decode($data, true);

        $product = $this->productService->updateProduct($product, $content);

        return new JsonResponse($product, Response::HTTP_OK);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function deleteProduct(Product $product): JsonResponse
    {
        $response = $this->productService->deleteProduct($product);

        return new JsonResponse(['message' => $response], Response::HTTP_OK);
    }
}
