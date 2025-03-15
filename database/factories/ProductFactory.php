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
            'name' => fake()->name(),
            'description' => fake()->paragraph(3, true),
            'price' => fake()->numberBetween(1, 100),
            'picture' => fake()->url(),
        ];
    }
}
