<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $fillable = [
        'position_id', 'gaji'
    ];

    public function position()
    {
        return $this->belongsTo('App\Models\Positions', 'position_id');
    }
}
