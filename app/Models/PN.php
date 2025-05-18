<?php
namespace App\Models;

class PN extends Ordination
{
    protected $singleTableSubType = 'PN';
    protected $hidden = [
        'morgen_dosis_id',
        'middag_dosis_id',
        'aften_dosis_id',
        'nat_dosis_id',
        'created_at', 
        'updated_at'
    ];
    public function dates()
    {
        return $this->hasMany(Dato::class, 'ordination_id');
    }
}
