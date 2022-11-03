<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products
     */
    public function all()
    {
        return Product::all();
    }

    /**
     * Get product pagination
     */
    public function paginate()
    {
        return Product::paginate(20);
    }

    /**
     * Create new product
     * 
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Product::create($data);
    }

    /**
     * Update product 
     * 
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }

    /**
     * Delete Product
     * 
     * @param \App\Models\Product $product
     * @return mixed
     */
    public function delete(Product $product)
    {
        return $product->delete();
    }
}
