<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Fortify\Fortify;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'north_latitude',
        'south_latitude',
        'east_longitude',
        'west_longitude',
        'issue',
        'solution',
    ];
    
}
