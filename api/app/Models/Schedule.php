<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'name', 'address', 'lat', 'lng'
    ];

    public function companies(){
        return $this->belongsTo('App\Models\Companies');
    }
}
