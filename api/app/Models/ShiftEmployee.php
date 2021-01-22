<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftEmployee extends Model
{
    protected $fillable = [
        'employee_id', 'shift_id', 'date'
    ];

    public function employess()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function shifts()
    {
        return $this->belongsTo('App\Models\Shift');
    }
}
