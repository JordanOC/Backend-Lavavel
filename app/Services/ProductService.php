<?php

namespace App\Services;

use App\Jobs\ImportProductImages;
use App\Models\Product;

class ProductService
{
    public function createProduct(array $data)
    {
        $product = Product::create($data);

        ImportProductImages::dispatch($product);

        return $product;
    }
}
