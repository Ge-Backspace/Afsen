<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Companies extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function offices(){
    	return $this->hasMany('App\Model\Office');
    }

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

    public function cuti(){
    	return $this->hasMany('App\Model\Cuti');
    }

}
