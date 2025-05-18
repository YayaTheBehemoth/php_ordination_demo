<?php
namespace Database\Factories;

use App\Models\DagligFast;
use App\Models\Patient;
use App\Models\Laegemiddel;
use App\Models\Dosis;
use Illuminate\Database\Eloquent\Factories\Factory;

class DagligFastFactory extends Factory
{
    protected $model = DagligFast::class;

    public function definition(): array
    {
        return [
            'type' => 'DagligFast',
            'start_den' => $this->faker->date(),
            'slut_den' => $this->faker->date(),
            'patient_id' => Patient::factory(),
            'laegemiddel_id' => Laegemiddel::factory(),
            'morgen_dosis_id' => Dosis::factory(),
            'middag_dosis_id' => Dosis::factory(),
            'aften_dosis_id' => Dosis::factory(),
            'nat_dosis_id' => Dosis::factory(),
        ];
    }
}
