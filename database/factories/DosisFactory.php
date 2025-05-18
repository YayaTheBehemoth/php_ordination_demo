<?php

namespace Database\Factories;

use App\Models\Dosis;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosisFactory extends Factory
{
    protected $model = Dosis::class;

    public function definition(): array
    {
        return [
            'tidspunkt' => $this->faker->dateTimeBetween('08:00', '22:00')->format('H:i:s'),
            'antal' => $this->faker->randomFloat(1, 0.5, 2.5),
        ];
    }
}
