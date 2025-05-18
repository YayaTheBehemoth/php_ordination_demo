<?php

namespace App\Repositories\Interfaces;

use App\Models\PN;
use Illuminate\Support\Collection;

interface PNRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?PN;
    public function create(array $data): PN;
}