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

    public function shcedule(){
    	return $this->hasMany('App\Model\Scedule');
    }

    public function shift(){
    	return $this->hasMany('App\Model\Shift');
    }

    public function employees(){
    	return $this->hasMany('App\Model\Employee');
    }
}
