<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name', 'file_id'
    ];

    public function files(){
        return $this->belongsTo('App\Models\Files\File', 'file_id');
    }

}
