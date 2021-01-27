<?php

namespace App\Imports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\ToModel;

class ShiftEmployeeImport implements ToModel
{
    public function model(array $row)
    {
        return new ShiftEmployee([
            'company_id' => $row[0],
            'employee_id' => $row[1],
            'shift_id' => $row[2],
            'date' => $row[3]
        ]);
    }
}
