<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    use HasFactory;

    public $table = 'brgys';

    protected $fillable = [
        'brgy_code',
        'brgy_name',
        'region_code',
        'province_code',
        'municipality_code',
    ];
}
