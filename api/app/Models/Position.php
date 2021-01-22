<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name', 'company_id'
    ];

    public function employees(){
    	return $this->hasMany('App\Model\Employee');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
