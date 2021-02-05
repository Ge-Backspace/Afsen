<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'position_name', 'group', 'company_id'
    ];

    public function employees(){
    	return $this->hasMany('App\Model\Employee');
    }

    public function companies()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
