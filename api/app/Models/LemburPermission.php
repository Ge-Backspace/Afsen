<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LemburPermission extends Model
{
    protected $fillable = [
        'employee_id', 'schedule_in', 'schedule_out', 'date', 'status', 'reason', 'status'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }
    public function evidences()
    {
        return $this->belongsTo('App\Models\Files\File', 'file_id');
    }
}
