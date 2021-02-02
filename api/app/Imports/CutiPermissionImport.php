<?php

namespace App\Imports;

use App\Models\CutiPermission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CutiPermissionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new CutiPermission([
            'employee_id' => $row['employee_id'],
            'cuti_id' => $row['cuti_id'],
            'start_date' => $row['start_date'],
            'expired_date' => $row['start_date'],
        ]);
    }
}
