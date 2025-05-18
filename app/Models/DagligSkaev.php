<?php

namespace App\Models;

class DagligSkaev extends Ordination
{
    protected $singleTableSubType = 'DagligSkaev';
    protected $hidden = [
        'morgen_dosis_id',
        'middag_dosis_id',
        'aften_dosis_id',
        'nat_dosis_id',
        'created_at', 
        'updated_at'
    ];
    public function doser()
    {
        return $this->hasMany(Dosis::class, 'ordination_id');
    }
}

