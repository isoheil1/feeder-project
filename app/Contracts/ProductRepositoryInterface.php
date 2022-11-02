<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all(): array;
    public function create(array $data);
    public function show(Product $product);
    public function update(Product $product, array $data);
    public function delete(Product $product);
}
