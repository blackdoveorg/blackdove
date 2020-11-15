<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Perches extends Model
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
        'ip_issue_distance',
        'issue',
        'solution',
        'social_compass',
        'economic_compass',
        'compass_color',
    ];
}
