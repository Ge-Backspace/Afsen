<?php

namespace App\Imports;

use App\Models\CutiPermission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftPermissionImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new CutiPermission([
            'employee1_id' => $row['employee1_id'],
            'employee2_id' => $row['employee2_id'],
            'shift_employee1_id' => $row['shift_employee1_id'],
            'shift_employee2_id' => $row['shift_employee2_id']
        ]);
    }
}
