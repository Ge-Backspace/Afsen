<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = [
        'name', 'address', 'lat', 'lng'
    ];

    public function users(){
    	return $this->hasMany('App\Model\User');
    }

    public function positions(){
    	return $this->hasMany('App\Model\Position');
    }

    public function shift(){
    	return $this->hasMany('App\Model\Shift');
    }

    public function shiftEmployee(){
    	return $this->hasMany('App\Model\ShiftEmployee');
    }

}
