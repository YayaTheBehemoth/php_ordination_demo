<?php

namespace App\Repositories;

use App\Models\Laegemiddel;
use App\Repositories\Interfaces\LaegemiddelRepositoryInterface;
use Illuminate\Support\Collection;

class LaegemiddelRepository implements LaegemiddelRepositoryInterface
{
    public function all(): Collection
    {
        return Laegemiddel::all();
    }

    public function find(int $id): ?Laegemiddel
    {
        return Laegemiddel::find($id);
    }

    public function create(array $data): Laegemiddel
    {
        return Laegemiddel::create($data);
    }
}