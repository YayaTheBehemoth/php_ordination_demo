<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laegemiddel extends Model
{
    use HasFactory;
    protected $table = 'laegemiddler';
    protected $fillable = [
        'navn',
        'enhedPrKgPrDoegnLet',
        'enhedPrKgPrDoegnNormal',
        'enhedPrKgPrDoegnTung',
        'enhed'
    ];

    public $timestamps = false;
}
