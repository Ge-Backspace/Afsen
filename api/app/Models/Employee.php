<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'user_id', 'nip', 'position_id', 'status', ''
    ];

    public function positions()
    {
        return $this->belongsTo('App\Models\Positions');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function checkins()
    {
        return $this->hasMany('App\Models\Checkin');
    }

    public function shift_employees()
    {
        return $this->hasMany('App\Models\SHifEmployee');
    }
}
