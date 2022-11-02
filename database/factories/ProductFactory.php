<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $availability = ['in_stock', 'out_of_stock', 'preorder', 'backorder'];

        return [
            'title' => fake()->text(20),
            'description' => fake()->text(),
            'sku' => fake()->words(10, true),
            'image_link' => 'https://localhost/images/fake.png',
            'availability' => $availability[array_rand($availability)],
            'availability_date' => fake()->dateTimeInInterval($startDate = '+7 days', $interval = '+ 30 days', $timezone = null),
            'price' => fake()->randomFloat(2, 10, 100),
        ];
    }

   
}
