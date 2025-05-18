<?php
namespace Database\Factories;

use App\Models\PN;
use App\Models\Patient;
use App\Models\Laegemiddel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PNFactory extends Factory
{
    protected $model = PN::class;

    public function definition(): array
    {
        return [
            'type' => 'PN',
            'start_den' => $this->faker->date(),
            'slut_den' => $this->faker->date(),
            'antal_enheder' => $this->faker->randomFloat(1, 1, 5),
            'patient_id' => Patient::factory(),
            'laegemiddel_id' => Laegemiddel::factory(),
        ];
    }
}
