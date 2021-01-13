<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Model;

class MultiFile extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_file', 'id_parent', 'type'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i:s',
        'updated_at' => 'date:d-m-Y H:i:s'
    ];

    protected $appends = ['file_url'];

    public function file()
    {
        return $this->hasOne('App\Models\File', 'id', 'id_file');
    }

    public function getFileUrlAttribute()
    {
        $file = $this->file()->first();
        if($file){
            $type = explode('-', $file->file_name)[0];
            return request()->getSchemeAndHttpHost() .'/storage/' . $type . '/' . $file->file_name;
        }
        return null;
    }
}