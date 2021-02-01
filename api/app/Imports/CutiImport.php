<?php

namespace App\Imports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CutiImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new Cuti([
            'company_id' => $this->company_id,
            'cuti_name' => $row['cuti_name'],
            'code' => $row['code'],
        ]);
    }
}
