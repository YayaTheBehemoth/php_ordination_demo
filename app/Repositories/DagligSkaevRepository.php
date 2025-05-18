<?php


namespace App\Repositories;

use App\Models\DagligSkaev;
use App\Repositories\Interfaces\DagligSkaevRepositoryInterface;
use Illuminate\Support\Collection;

class DagligSkaevRepository implements DagligSkaevRepositoryInterface
{
    
 public function all(): Collection
{
    return DagligSkaev::where('type', 'DagligSkaev')
        ->with([
            'laegemiddel',
            'patient',
            'doser:id,tidspunkt,antal,ordination_id'
        ])
        ->get();
}

public function find(int $id): ?DagligSkaev
{
    return DagligSkaev::where('type', 'DagligSkaev')
        ->with([
            'laegemiddel',
            'patient',
            'doser:id,tidspunkt,antal,ordination_id'
        ])
        ->find($id);
}

    public function create(array $data): DagligSkaev
    {
        return DagligSkaev::create($data);
    }
}