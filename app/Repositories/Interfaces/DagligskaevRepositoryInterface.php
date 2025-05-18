<?php

namespace App\Repositories\Interfaces;

use App\Models\DagligSkaev;
use Illuminate\Support\Collection;

interface DagligskaevRepositoryInterface
{
    public function all(): Collection;
   
    public function create(array $data): DagligSkaev;
}