<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Patient, Laegemiddel, Dosis, PN, DagligFast, DagligSkaev};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $laegemidler = Laegemiddel::factory()->count(5)->create();
        $patients = Patient::factory()->count(5)->create();

        $randPatient = fn () => $patients->random();
        $randMed = fn () => $laegemidler->random();

        // --- PN ---
        for ($i = 0; $i < 2; $i++) {
            [$start, $end] = $this->generateValidDateRange();

            PN::factory()->create([
                'start_den' => $start,
                'slut_den' => $end,
                'laegemiddel_id' => $randMed()->id,
                'patient_id' => $randPatient()->id,
            ]);
        }

        // --- DagligFast ---
        for ($i = 0; $i < 2; $i++) {
            [$start, $end] = $this->generateValidDateRange();

            DagligFast::factory()->create([
                'start_den' => $start,
                'slut_den' => $end,
                'laegemiddel_id' => $randMed()->id,
                'patient_id' => $randPatient()->id,
            ]);
        }

        // --- DagligSkaev ---
        for ($i = 0; $i < 2; $i++) {
            [$start, $end] = $this->generateValidDateRange();

            $skaev = DagligSkaev::factory()->create([
                'start_den' => $start,
                'slut_den' => $end,
                'laegemiddel_id' => $randMed()->id,
                'patient_id' => $randPatient()->id,
            ]);

            foreach (range(1, rand(3, 4)) as $_) {
                $skaev->doser()->create(Dosis::factory()->make()->toArray());
            }
        }
    }

    private function generateValidDateRange(): array
    {
        $start = now()->subDays(rand(1, 10));
        $end = (clone $start)->addDays(rand(1, 7));
        return [$start->toDateString(), $end->toDateString()];
    }
}
