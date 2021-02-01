<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftPermission extends Model
{
    protected $fillable = [
        'employee1_id', 'employee2_id', 'shift_employee1_id', 'shift_employee2_id', 'status_id'
    ];

    public function employees(){
        return $this->belongsTo('App\Models\Employee', ['employee1_id', 'employee2_id']);
    }

    public function shift_employees(){
        return $this->belongsTo('App\Models\ShiftEmployee', ['shift_employee1_id', 'shift_employee2_id']);
    }
}
