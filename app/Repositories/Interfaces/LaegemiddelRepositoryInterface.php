<?php

namespace App\Repositories\Interfaces;

use App\Models\Laegemiddel;
use Illuminate\Support\Collection;

interface LaegemiddelRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Laegemiddel;
    public function create(array $data): Laegemiddel;
}