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
}
