<?php

namespace App\Repositories\Interfaces;

use App\Models\Dosis;
use Illuminate\Support\Collection;

interface DosisRepositoryInterface
{
    public function create(array $data): Dosis;
}