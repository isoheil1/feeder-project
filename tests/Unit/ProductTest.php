<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\User;
use Str;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test list of products
     *
     * @return void
     */
    public function test_product_index()
    {
        $response = $this->get(route('product.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [],
            'success' => true
        ]);
    }

    public function test_product_store()
    {
        $response = $this->actingAs(User::first())->post(route('product.store'), [
            'title' => 'beauty',
            'description' => 'This is a beautiful product',
            'sku' => Str::upper(Str::random(10)),
            'image_link' => 'http://localhost/image.png',
            'availability' => 'in_stock',
            'availability_date' => '2023-10-1',
            'price' => '10',
            'brand' => 'jordan',
            'condition' => 'new',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'beauty',
            ],
            'success' => true
        ]);
    }

    public function test_product_store_invalid_args()
    {
        $response = $this->actingAs(User::first())->post(route('product.store'), [
            'title' => 'beauty',
            'description' => 'This is a beautiful product',
            'condition' => 'invalid_cond',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false
        ]);
    }

    public function test_product_store_unauthenticated()
    {
        $response = $this->post(route('product.store'), [
            'title' => 'beauty',
            'description' => 'This is a beautiful product',
            'condition' => 'invalid_cond',
        ]);

        $response->assertStatus(401);
    }

    public function test_product_destroy()
    {
        $response = $this->actingAs(User::first())->delete(route('product.destroy', ['product' => Product::inRandomOrder()->first()]));
        $response->assertStatus(204);
    }

    public function test_product_show()
    {
        $product = Product::inRandomOrder()->first();
        $response = $this->get(route('product.show', ['product' => $product]));
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $product->id
            ],
            'success' => true
        ]);
    }

    public function test_product_update()
    {
        $response = $this->actingAs(User::first())->put(route('product.update', ['product' => Product::inRandomOrder()->first()]), [
            'title' => 'beauty 2',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => 'beauty 2',
            ],
            'success' => true
        ]);
    }
}
