<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $unique = 'E200' . rand(4000, 8000) . 'A' . rand(1000, 9999);

        return [
            'name' => fake()->sentence(),
            'uuid' => $unique,
            'dealer_id' => rand(1, 3),
            'status_id' => rand(1, 2),
        ];
    }
}
