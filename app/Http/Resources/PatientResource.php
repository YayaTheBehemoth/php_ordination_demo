<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cprnr' => $this->cprnr,
            'navn' => $this->navn,
            'vaegt' => $this->vaegt,
            'ordinationer' => $this->ordinationer
                ? $this->ordinationer->map(function ($ord) {
                    switch ($ord->type) {
                        case 'PN':
                            return new PNResource($ord);
                        case 'DagligFast':
                            return new DagligFastResource($ord);
                        case 'DagligSkaev':
                            return new DagligSkaevResource($ord);
                        default:
                            return null;
                    }
                })->filter()->values()
                : [],
        ];
    }
}