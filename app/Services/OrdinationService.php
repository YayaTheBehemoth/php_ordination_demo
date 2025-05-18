<?php


namespace App\Services;

use App\Models\{Dato, PN, DagligFast, DagligSkaev, Dosis};
use App\Repositories\Interfaces\{
    PatientRepositoryInterface,
    LaegemiddelRepositoryInterface,
    PNRepositoryInterface,
    DagligFastRepositoryInterface,
    DagligSkaevRepositoryInterface,
    OrdinationRepositoryInterface,
    DosisRepositoryInterface
};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrdinationService
{
    protected PatientRepositoryInterface $patients;
    protected LaegemiddelRepositoryInterface $laegemidler;
    protected PNRepositoryInterface $pnRepo;
    protected DagligFastRepositoryInterface $dagligFastRepo;
    protected DagligSkaevRepositoryInterface $dagligSkaevRepo;
    protected OrdinationRepositoryInterface $ordinationRepo;
    protected DosisRepositoryInterface $dosisRepo;

    public function __construct(
        PatientRepositoryInterface $patients,
        LaegemiddelRepositoryInterface $laegemidler,
        PNRepositoryInterface $pnRepo,
        DagligFastRepositoryInterface $dagligFastRepo,
        DagligSkaevRepositoryInterface $dagligSkaevRepo,
        OrdinationRepositoryInterface $ordinationRepo,
        DosisRepositoryInterface $dosisRepo
    ) {
        $this->patients = $patients;
        $this->laegemidler = $laegemidler;
        $this->pnRepo = $pnRepo;
        $this->dagligFastRepo = $dagligFastRepo;
        $this->dagligSkaevRepo = $dagligSkaevRepo;
        $this->ordinationRepo = $ordinationRepo;
        $this->dosisRepo = $dosisRepo;
    }

    public function getPatienter(): Collection
    {
        try {
            return $this->patients->all();
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente patienter: " . $e->getMessage());
        }
    }

    public function getLaegemidler(): Collection
    {
        try {
            return $this->laegemidler->all();
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente lægemidler: " . $e->getMessage());
        }
    }

    public function getPN(): Collection
    {
        try {
            return $this->pnRepo->all();
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente PN ordinationer: " . $e->getMessage());
        }
    }

    public function getDagligFaste(): Collection
    {
        try {
            return $this->dagligFastRepo->all();
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente DagligFast ordinationer: " . $e->getMessage());
        }
    }

    public function getDagligSkaev(): Collection
    {
        try {
            return $this->dagligSkaevRepo->all();
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente DagligSkaev ordinationer: " . $e->getMessage());
        }
    }

    public function opretPN(int $patientId, int $laegemiddelId, float $antal, string $startDato, string $slutDato): PN
    {
        try {
            return PN::create([
                'type' => 'PN',
                'start_den' => $startDato,
                'slut_den' => $slutDato,
                'antal_enheder' => $antal,
                'laegemiddel_id' => $laegemiddelId,
                'patient_id' => $patientId,
            ]);
        } catch (Exception $e) {
            throw new Exception("Kunne ikke oprette PN ordination: " . $e->getMessage());
        }
    }

    public function opretDagligFast($patientId, $laegemiddelId, $morgen, $middag, $aften, $nat, $startDato, $slutDato)
    {
        try {
            $morgenDosis = Dosis::create($morgen);
            $middagDosis = Dosis::create($middag);
            $aftenDosis  = Dosis::create($aften);
            $natDosis    = Dosis::create($nat);

            $fast = DagligFast::create([
                'type' => 'DagligFast',
                'start_den' => $startDato,
                'slut_den' => $slutDato,
                'patient_id' => $patientId,
                'laegemiddel_id' => $laegemiddelId,
                'morgen_dosis_id' => $morgenDosis->id,
                'middag_dosis_id' => $middagDosis->id,
                'aften_dosis_id' => $aftenDosis->id,
                'nat_dosis_id' => $natDosis->id,
            ]);

            // Eager load relationships for the resource
            return $fast->fresh(['morgenDosis', 'middagDosis', 'aftenDosis', 'natDosis', 'laegemiddel']);
        } catch (Exception $e) {
            throw new Exception("Kunne ikke oprette DagligFast ordination: " . $e->getMessage());
        }
    }

public function opretDagligSkaev(int $patientId, int $laegemiddelId, array $doser, string $startDato, string $slutDato): DagligSkaev
{
    try {
        $skaev = DagligSkaev::create([
            'type' => 'DagligSkaev',
            'start_den' => $startDato,
            'slut_den' => $slutDato,
            'laegemiddel_id' => $laegemiddelId,
            'patient_id' => $patientId,
        ]);

        foreach ($doser as $dosisData) {
            $skaev->doser()->create($dosisData); 
        }

        return $skaev->fresh(['doser', 'laegemiddel']);
    } catch (Exception $e) {
        throw new Exception("Kunne ikke oprette DagligSkaev ordination: " . $e->getMessage());
    }
}

    public function getStats(float $vfra, float $vtil, int $laegemiddelId): int
    {
        try {
            $patients = $this->patients->all()->filter(function ($p) use ($vfra, $vtil) {
                return $p->vaegt > $vfra && $p->vaegt < $vtil;
            });

            $count = 0;
            foreach ($patients as $p) {
                foreach ($p->ordinationer as $ord) {
                    if ($ord->laegemiddel_id == $laegemiddelId) {
                        $count++;
                    }
                }
            }
            return $count;
        } catch (Exception $e) {
            throw new Exception("Kunne ikke hente statistik: " . $e->getMessage());
        }
    }

    public function anvendOrdination(int $pnId, string $date): string
    {
        try {
            $pn = $this->pnRepo->find($pnId);
            if (!$pn) {
                throw new ModelNotFoundException("Ordination ikke fundet.");
            }
            $givenDate = Carbon::parse($date);

            if ($givenDate >= $pn->start_den && $givenDate <= $pn->slut_den) {
                $dato = new Dato(['dato' => $givenDate]);
                $pn->dates()->save($dato);
                return "Din anmodning er blevet godkendt, ordinationen kan anvendes";
            }

            throw new Exception("Din anmodning er blevet afvist, da du har forsøgt at anvende ordinationen udenfor dennes gyldighedsperiode");
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new Exception("Fejl ved anvendelse af ordination: " . $e->getMessage());
        }
    }

    public function getAnbefaletDosisPerDoegn(int $patientId, int $laegemiddelId): float
    {
        try {
            $patient = $this->patients->find($patientId);
            $lm = $this->laegemidler->find($laegemiddelId);

            if ($patient->vaegt < 25) {
                return $lm->enhedPrKgPrDoegnLet;
            } elseif ($patient->vaegt > 120) {
                return $lm->enhedPrKgPrDoegnTung;
            } else {
                return $lm->enhedPrKgPrDoegnNormal;
            }
        } catch (Exception $e) {
            throw new Exception("Kunne ikke beregne anbefalet dosis: " . $e->getMessage());
        }
    }
}