<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'user_id', 'nip', 'position_id', 'status', 'kontak',
    ];

    public function positions()
    {
        return $this->belongsTo('App\Models\Position', 'position_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
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
