<?php

namespace App\Services;

use App\Helpers\PagintaionHelper;
use App\Models\Product;

class ProductService
{
    /**
     * @param $queryParams
     * @return array
     */
    public function getAllProducts($queryParams): array
    {
        $query = Product::query();

        if (isset($queryParams['title'])) {
            $query->where('title', 'LIKE', "%{$queryParams['title']}%");
        }

        if (isset($queryParams['weight'])) {
            $query->where('weight', 'LIKE', "%{$queryParams['weight']}%");
        }

        $products = $query->get();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($products, $showPerPage, $queryParams);

        return $paginated;

    }

    /**
     * @param $product
     * @return Product|null
     */
    public function getProductById($product): ?Product
    {
        return $product;
    }

    /**
     * @param array $data
     * @return Product|null
     */
    public function createProduct(array $data): ?Product
    {
        $product = new Product();
        $product->title = $data['title'] ?? null;
        $product->weight = $data['weight'] ?? null;

        $product->save();

        return $product;
    }

    /**
     * @param $product
     * @param array $data
     * @return Product|null
     */
    public function updateProduct($product, array $data): ?Product
    {
        $product->title = $data['title'] ?? null;
        $product->weight = $data['weight'] ?? null;

        $product->save();

        return $product;
    }

    /**
     * @param $product
     * @return string
     */
    public function deleteProduct($product): string
    {
        $product->delete();

        return 'Product was removed';
    }
}
