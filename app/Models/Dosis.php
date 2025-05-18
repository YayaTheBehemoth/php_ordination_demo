<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosis extends Model
{
    use HasFactory;
    protected $table = 'doser';
    protected $fillable = ['tidspunkt', 'antal','ordination_id'];

    public $timestamps = false;
}