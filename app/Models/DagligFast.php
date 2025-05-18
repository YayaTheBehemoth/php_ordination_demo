<?php

namespace App\Models;

class DagligFast extends Ordination
{
    protected $singleTableSubType = 'DagligFast';
    public function morgenDosis()
    {
        return $this->belongsTo(Dosis::class, 'morgen_dosis_id');
    }

    public function middagDosis()
    {
        return $this->belongsTo(Dosis::class, 'middag_dosis_id');
    }

    public function aftenDosis()
    {
        return $this->belongsTo(Dosis::class, 'aften_dosis_id');
    }

    public function natDosis()
    {
        return $this->belongsTo(Dosis::class, 'nat_dosis_id');
    }
    
    protected $hidden = [
    'morgen_dosis_id',
    'middag_dosis_id',
    'aften_dosis_id',
    'nat_dosis_id',
    'created_at', 
    'updated_at'
];
}
