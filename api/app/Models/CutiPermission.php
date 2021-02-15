<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CutiPermission extends Model
{
    protected $fillable = [
        'employee_id', 'cuti_id', 'status_id', 'start_date', 'expired_date', 'reason', 'file_id'
    ];

    public function employees(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function cutis(){
        return $this->belongsTo('App\Models\Cuti');
    }

    public function status_permission(){
        return $this->belongsTo('App\Models\StatusPermission');
    }
}
