<?php

namespace App\Imports;

use App\Models\StatusPermission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StatusPermissionImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new StatusPermission([
            'company_id' => $this->company_id,
            'status_name' => $row['status_name'],
            'code' => $row['code'],
        ]);
    }
}
