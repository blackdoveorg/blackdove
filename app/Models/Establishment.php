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
        'user_id',
        'latitude',
        'longitude',
        'ip_latitude',
        'ip_longitude',
        'north_latitude',
        'south_latitude',
        'east_longitude',
        'west_longitude',
        'cross_distance',
        'issue',
        'solution',
    ];
    
}
