<?php


namespace App\Repositories;

use App\Models\DagligFast;
use App\Repositories\Interfaces\DagligFastRepositoryInterface;
use Illuminate\Support\Collection;

class DagligFastRepository implements DagligFastRepositoryInterface
{
    public function all(): Collection
    {
        return DagligFast::where('type', 'DagligFast')
            ->with([
              'laegemiddel',
              'patient',
              'morgenDosis:id,tidspunkt,antal',
              'middagDosis:id,tidspunkt,antal',
              'aftenDosis:id,tidspunkt,antal',
              'natDosis:id,tidspunkt,antal'
            ])
            ->get();
    }

    public function find(int $id): ?DagligFast
    {
         return DagligFast::where('type', 'DagligFast')
            ->with([
              'laegemiddel',
              'patient',
              'morgenDosis:id,tidspunkt,antal',
              'middagDosis:id,tidspunkt,antal',
              'aftenDosis:id,tidspunkt,antal',
              'natDosis:id,tidspunkt,antal'
            ])
            ->find($id);
    }

    public function create(array $data): DagligFast
    {
        return DagligFast::create($data);
    }
}