<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dato extends Model
{
    use HasFactory;
    protected $table = 'datoer';
    protected $fillable = ['dato'];
    
protected $casts = [
    'dato' => 'date', 
];

    public $timestamps = false;
public function ordination()
{
    return $this->belongsTo(Ordination::class);
}
}
