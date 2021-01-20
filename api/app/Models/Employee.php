<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'company_id', 'user_id', 'nip', 'position_id', 'status'
    ];

    public function companies()
    {
        return $this->belongsTo('App\Models\Companies');
    }

    public function positions()
    {
        return $this->belongsTo('App\Models\Positions');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
