<?php

namespace App\Repositories\Interfaces;

use App\Models\Patient;
use Illuminate\Support\Collection;

interface PatientRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Patient;
}