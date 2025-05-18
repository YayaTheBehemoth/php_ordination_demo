<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LaegemiddelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'navn' => $this->navn,
            'enhedPrKgPrDoegnLet' => $this->enhedPrKgPrDoegnLet,
            'enhedPrKgPrDoegnNormal' => $this->enhedPrKgPrDoegnNormal,
            'enhedPrKgPrDoegnTung' => $this->enhedPrKgPrDoegnTung,
            'enhed' => $this->enhed,
       
            
       ];
    }
}