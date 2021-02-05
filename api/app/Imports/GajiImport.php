<?php

namespace App\Imports;

use App\Models\Gaji;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GajiImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new Gaji([
            'position_id' => $row['position_id'],
            'gaji' => $row['gaji']
        ]);
    }
}
