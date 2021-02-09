<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyCheckout extends Model
{
    protected $fillable = [
        'reason', 'checkin_id'
    ];

    public function checkin()
    {
        $this->belongsTo('App\Models\Checkin', 'checkin_id');
    }
}
