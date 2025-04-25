<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->word(),
            'description' => fake()->sentence(10),
            'price' => fake()->numberBetween(1, 100),
            'picture' => fake()->imageUrl(640, 480, 'product', true),
        ];
    }
}
