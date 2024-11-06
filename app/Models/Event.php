<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'start_time', 'location', 'latitude', 'longitude', 'image'];

    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime:H:i',
    ];
}
