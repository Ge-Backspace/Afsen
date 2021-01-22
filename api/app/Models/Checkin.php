<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'user_id', 'lat', 'lng','checkin_time', 'address',
    ];

    public function employees()
    {
        $this->belongsTo('App\Models\Employee');
    }
}
