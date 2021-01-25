<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = [
        'id', 'created_at', 'updated_at'
    ];

    protected $fillable = [
        'title', 'slug', 'description', 'price', 'stock'
    ];
}
