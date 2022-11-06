<?php

namespace App\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all();
    public function paginate(int $perPage);
    public function count(): int;
    public function create(array $data);
    public function update(Product $product, array $data);
    public function delete(Product $product);
}
