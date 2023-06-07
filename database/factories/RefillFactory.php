<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Refill>
 */
class RefillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'warehouse_id' => rand(1, 5),
            'product_id' => rand(1, 10),
            'quantity' => rand(1, 10),
            'status' => 'low',
        ];
    }
}
