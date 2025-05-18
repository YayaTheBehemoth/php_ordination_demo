<?php


namespace App\Repositories;

use App\Models\PN;
use App\Repositories\Interfaces\PNRepositoryInterface;
use Illuminate\Support\Collection;

class PNRepository implements PNRepositoryInterface
{
    public function all(): Collection
    {
        return PN::where('type', 'PN')
            ->with(['laegemiddel', 'patient', 'dates'])
            ->get();
    }

    public function find(int $id): ?PN
    {
        return PN::where('type', 'PN')
            ->with(['laegemiddel', 'patient', 'dates'])
            ->find($id);
    }

    public function create(array $data): PN
    {
        return PN::create($data);
    }
}