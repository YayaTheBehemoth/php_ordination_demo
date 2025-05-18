<?php
namespace Database\Factories;

use App\Models\DagligSkaev;
use App\Models\Patient;
use App\Models\Laegemiddel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DagligSkaevFactory extends Factory
{
    protected $model = DagligSkaev::class;

    public function definition(): array
    {
        return [
            'type' => 'DagligSkaev',
            'start_den' => $this->faker->date(),
            'slut_den' => $this->faker->date(),
            'patient_id' => Patient::factory(),
            'laegemiddel_id' => Laegemiddel::factory(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($skaev) {
            \App\Models\Dosis::factory()
                ->count(rand(3, 4))
                ->create(['ordination_id' => $skaev->id]);
        });
    }
}
