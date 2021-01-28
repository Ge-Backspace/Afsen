<?php

namespace App\Imports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\ToModel;

class ShiftEmployeeImport implements ToModel
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new ShiftEmployee([
            'company_id' => $this->company_id,
            'employee_id' => $row[0],
            'shift_id' => $row[1],
            'date' => $row[2]
        ]);
    }
}
