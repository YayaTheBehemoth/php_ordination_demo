<?php

namespace App\Repositories\Interfaces;

use App\Models\Ordination;
use Illuminate\Support\Collection;

interface OrdinationRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Ordination;
}