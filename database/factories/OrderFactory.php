<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => fake()->optional()->numberBetween(1, 2),
            'warehouse_id' => fake()->numberBetween(1, 2),
            'uuid' => fake()->uuid(),
        ];
    }
}
