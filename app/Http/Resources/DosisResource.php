<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DosisResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tidspunkt' => $this->tidspunkt,
            'antal' => $this->antal,
            
        ];
    }
}