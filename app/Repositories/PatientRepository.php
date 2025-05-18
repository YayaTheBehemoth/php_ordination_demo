<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Support\Collection;

class PatientRepository implements PatientRepositoryInterface
{
    public function all(): Collection
    {
        return Patient::with('ordinationer')->get();
    }

    public function find(int $id): ?Patient
    {
        return Patient::with('ordinationer')->find($id);
    }

 
}