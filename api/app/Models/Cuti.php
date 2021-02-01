<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    protected $fillable = [
        'cuti_name', 'company_id', 'code'
    ];

    public function companies(){
        return $this->belongsTo('App\Models\Companies');
    }
}
