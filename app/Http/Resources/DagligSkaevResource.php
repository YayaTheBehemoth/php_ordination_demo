<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DagligSkaevResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'start_den' => $this->start_den ? $this->start_den->format('Y-m-d') : null,
            'slut_den' => $this->slut_den ? $this->slut_den->format('Y-m-d') : null,
            'laegemiddel' => new LaegemiddelResource($this->whenLoaded('laegemiddel')),
            
            'doser' => DosisResource::collection($this->whenLoaded('doser')),
        ];
    }
}