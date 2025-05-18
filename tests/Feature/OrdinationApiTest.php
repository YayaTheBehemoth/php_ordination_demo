<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Patient;
use App\Models\Laegemiddel;

class OrdinationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_pn_ordination_success()
    {
        $patient = Patient::factory()->create();
        $laegemiddel = Laegemiddel::factory()->create();

        $response = $this->postJson('/api/ordination/pn', [
            'patientId' => $patient->id,
            'laegemiddelId' => $laegemiddel->id,
            'antal' => 2,
            'startDato' => '2025-05-20',
            'slutDato' => '2025-05-27'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'type' => 'PN',
                     'antal_enheder' => 2,
                     'start_den' => '2025-05-20',
                     'slut_den' => '2025-05-27'
                 ]);
    }

    public function test_create_dagligfast_ordination_with_doses()
    {
        $patient = Patient::factory()->create();
        $laegemiddel = Laegemiddel::factory()->create();

        $response = $this->postJson('/api/ordination/daglig-fast', [
            'patientId' => $patient->id,
            'laegemiddelId' => $laegemiddel->id,
            'morgen' => ['tidspunkt' => '08:00', 'antal' => 1],
            'middag' => ['tidspunkt' => '12:00', 'antal' => 1],
            'aften'  => ['tidspunkt' => '18:00', 'antal' => 1],
            'nat'    => ['tidspunkt' => '22:00', 'antal' => 1],
            'startDato' => '2025-05-20',
            'slutDato' => '2025-05-27'
        ]);
        // dump($response->json());
        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'type' => 'DagligFast',
                     'start_den' => '2025-05-20',
                     'slut_den' => '2025-05-27'
                 ])
                 ->assertJsonPath('data.morgen_dosis.tidspunkt', '08:00')
                 ->assertJsonPath('data.morgen_dosis.antal', 1);
    }

    public function test_validation_error_when_missing_required_fields()
    {
        $response = $this->postJson('/api/ordination/pn', [
            // mangler patientId, laegemiddelId, antal, startDato, slutDato
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                     'errors' => [
                         'patientId',
                         'laegemiddelId',
                         'antal',
                         'startDato',
                         'slutDato'
                     ]
                 ]);
    }

    public function test_create_dagligskaev_ordination_with_multiple_doses()
    {
        $patient = Patient::factory()->create();
        $laegemiddel = Laegemiddel::factory()->create();

        $response = $this->postJson('/api/ordination/daglig-skaev', [
            'patientId' => $patient->id,
            'laegemiddelId' => $laegemiddel->id,
            'doser' => [
                ['tidspunkt' => '08:00', 'antal' => 1.5],
                ['tidspunkt' => '14:00', 'antal' => 2]
            ],
            'startDato' => '2025-05-20',
            'slutDato' => '2025-05-27'
        ]);
     
        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'type' => 'DagligSkaev',
                     'start_den' => '2025-05-20',
                     'slut_den' => '2025-05-27'
                 ])
                 ->assertJsonPath('data.doser.0.tidspunkt', '08:00')
                 ->assertJsonPath('data.doser.0.antal', 1.5)
                 ->assertJsonPath('data.doser.1.tidspunkt', '14:00')
                 ->assertJsonPath('data.doser.1.antal', 2);
    }

   public function test_anvend_ordination_outside_validity_period_returns_error()
{
    $patient = Patient::factory()->create();
    $laegemiddel = Laegemiddel::factory()->create();

    $response = $this->postJson('/api/ordination/pn', [
        'patientId' => $patient->id,
        'laegemiddelId' => $laegemiddel->id,
        'antal' => 2,
        'startDato' => '2025-05-20',
        'slutDato' => '2025-05-27'
    ]);
    $pnId = $response->json('data.id');
    $response = $this->postJson('/api/ordination/anvend', [
        'pnId' => $pnId,
        'date' => '2025-06-01' // ugyldig
    ]);

    // Accept Laravel's default: 500 status and message key
    $response->assertStatus(500)
             ->assertJson([
                 'message' => 'Fejl ved anvendelse af ordination: Din anmodning er blevet afvist, da du har forsøgt at anvende ordinationen udenfor dennes gyldighedsperiode'
             ]);
}

    public function test_anvend_ordination_not_found_returns_404()
    {
        $response = $this->postJson('/api/ordination/anvend', [
            'pnId' => 999999,
            'date' => '2025-05-21'
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Ordination ikke fundet.'
                 ]);
    }
}