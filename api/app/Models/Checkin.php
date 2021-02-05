<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Checkin extends Model
{
    protected $fillable = [
        'employee_id', 'lat', 'lng', 'checkin_time','checkout_time', 'address',
    ];

    public function employees()
    {
        $this->belongsTo('App\Models\Employee', 'employee_id');
    }
}
