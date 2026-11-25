<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => fn () => Category::firstOrCreate(
                ['name' => 'General'],
                ['active' => true]
            )->id,
            'name' => fake()->unique()->words(3, true),
            'price' => fake()->randomFloat(2, 1000, 100000),
            'stock' => fake()->numberBetween(10, 50),
            'active' => true,
        ];
    }
}
