<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DatoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dato' => $this->dato ? $this->dato->format('Y-m-d') : null,
            
        ];
    }
}