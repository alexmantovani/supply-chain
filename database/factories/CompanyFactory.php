<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),

            // 'email' => fake()->companyEmail(),
            // 'address'  => fake()->streetAddress(),
            // 'zip_code' => rand(40100, 40180),
            // 'city' => fake()->city(),
        ];
    }
}
