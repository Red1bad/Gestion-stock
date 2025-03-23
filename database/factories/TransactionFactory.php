<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transactionable = $this->faker->randomElement([
            Customer::class,
            Supplier::class
        ]);

        return [
            'tansactionable_id' => $transactionable::factory(),
            'tansactionable_type' => $transactionable,
            'content' => fake()->paragraph()
        ];
    }


    public function forCommentable(Model $transactionablee): static
    {
        return $this->state(fn (array $attributes) => [
            'tansactionable_id' => $transactionablee->id,
            'tansactionable_type' => get_class($transactionablee),
        ]);
    }
}