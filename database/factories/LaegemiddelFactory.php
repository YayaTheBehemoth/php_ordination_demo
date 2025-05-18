<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laegemiddel>
 */
class LaegemiddelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
{
    return [
        'navn' => $this->faker->word(),
        'enhedPrKgPrDoegnLet' => $this->faker->randomFloat(2, 0.01, 0.5),
        'enhedPrKgPrDoegnNormal' => $this->faker->randomFloat(2, 0.5, 1.5),
        'enhedPrKgPrDoegnTung' => $this->faker->randomFloat(2, 1.5, 2.5),
        'enhed' => $this->faker->randomElement(['ml', 'styk']),
    ];
}
}
