<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * @return Collection
     */
    public function getAllProducts(): Collection
    {
        return Product::all();
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
