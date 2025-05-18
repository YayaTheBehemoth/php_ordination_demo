<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'cprnr' => $this->faker->regexify('[0-9]{6}-[0-9]{4}'),
        'navn' => $this->faker->name(),
        'vaegt' => $this->faker->randomFloat(1, 40, 130),
    ];
}
}
