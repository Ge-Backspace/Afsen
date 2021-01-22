<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            //
            'title' => $row[0],
            'slug' => Str::slug($row[0]),
            'description' => $row[1],
            'price' => $row[2],
            'stock' => $row[3]
        ]);
    }
}
