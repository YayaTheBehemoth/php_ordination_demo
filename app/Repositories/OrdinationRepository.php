<?php

namespace App\Repositories;

use App\Models\Ordination;
use App\Repositories\Interfaces\OrdinationRepositoryInterface;
use Illuminate\Support\Collection;

class OrdinationRepository implements OrdinationRepositoryInterface
{
    public function all(): Collection
    {
        return Ordination::with('laegemiddel')->get();
    }

    public function find(int $id): ?Ordination
    {
        return Ordination::with('laegemiddel')->find($id);
    }
}