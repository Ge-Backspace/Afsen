<?php

namespace App\Imports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftEmployeeImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new ShiftEmployee([
            'company_id' => $this->company_id,
            'employee_id' => $row['employee'],
            'shift_id' => $row['shift'],
            'date' => $row['date']
        ]);
    }
}
