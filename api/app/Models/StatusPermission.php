<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusPermission extends Model
{
    protected $fillable = [
        'status_name', 'company_id', 'code'
    ];

    public function companies(){
        return $this->belongsTo('App\Models\Companies');
    }
}
