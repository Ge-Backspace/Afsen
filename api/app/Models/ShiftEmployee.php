<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftEmployee extends Model
{
    protected $fillable = [
        'employee_id', 'shift_id', 'date'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Models\Employee');
    }

    public function shifts()
    {
        return $this->belongsTo('App\Models\Shift');
    }
}
