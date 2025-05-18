<?php

namespace App\Repositories;

use App\Models\Dosis;
use App\Repositories\Interfaces\DosisRepositoryInterface;

class DosisRepository implements DosisRepositoryInterface
{
    public function create(array $data): Dosis
    {
        return Dosis::create($data);
    }
}