<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ordination extends Model
{
    use HasFactory;

    protected $table = 'ordinationer';
    protected $singleTableType = 'type';
    protected $fillable = [
        'type',
        'start_den',
        'slut_den',
        'laegemiddel_id',
        'patient_id',
        'antal_enheder',
        'morgen_dosis_id',
        'middag_dosis_id',
        'aften_dosis_id',
        'nat_dosis_id'
    ];

    public $timestamps = false;

   protected $casts = [
    'start_den' => 'date:Y-m-d',
    'slut_den' => 'date:Y-m-d',
];
  

    public function laegemiddel()
    {
        return $this->belongsTo(Laegemiddel::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
 


}
