<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'extension', 'path', 'size'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i:s',
        'updated_at' => 'date:d-m-Y H:i:s'
    ];
}