<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'office_name', 'company_id','lat', 'lng', 'address'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Companies', 'position_id');
    }
}
