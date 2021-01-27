<?php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;

class ShiftImport implements ToModel
{
    public function model(array $row)
    {
        return new Shift([
            'company_id' => $row[0],
            'shift_name' => $row[1],
            'code' => $row[2],
            'schedule_in' => $row[3],
            'schedule_out' => $row[4],
        ]);
    }
}
