<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality_code',
        'municipality_name',
        'region_code',
        'province_code',
        'zip_code',
    ];
}
