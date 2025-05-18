<?php

namespace App\Repositories\Interfaces;

use App\Models\DagligFast;
use Illuminate\Support\Collection;

interface DagligFastRepositoryInterface
{
    public function all(): Collection;
  
    public function create(array $data): DagligFast;
}