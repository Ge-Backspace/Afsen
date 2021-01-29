<?php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        return new Shift([
            'company_id' => $this->company_id,
            'shift_name' => $row['shift_name'],
            'code' => $row['code'],
            'schedule_in' => $row['schedule_in'],
            'schedule_out' => $row['schedule_out'],
        ]);
    }
}
