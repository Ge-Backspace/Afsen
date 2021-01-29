<?php

namespace App\Exports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShiftEmployeeExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return ShiftEmployee::join('employees', 'employees.id', '=', 'shift_employees.employee_id')
        ->join('shifts', 'shifts.id', '=', 'shift_employees.shift_id')
        ->where('shift_employees.company_id', $this->company_id)
        ->get(['employees.name',
        'shifts.shift_name',
        'shifts.code',
        'shifts.schedule_in',
        'shifts.schedule_out',
        'shift_employees.date'
        ]);
    }
}
