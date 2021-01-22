<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'company_id', 'name', 'code', 'schedule_in', 'schedule_out',
    ];

    public function companies(){
        return $this->belongsTo('App\Models\Companies');
    }

    public function shift_employees()
    {
        return $this->hasMany('App\Models\ShiftEmployee');
    }
}
