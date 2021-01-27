<?php

namespace App\Exports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShiftEmployeeExport implements FromCollection
{
    protected $user_id;

    function __construct($user_id) {
            $this->user_id = $user_id;
    }
    public function collection()
    {
        return ShiftEmployee::join('employees', 'employees.id', '=', 'shift_employees.employee_id')
        ->join('shifts', 'shifts.id', '=', 'shift_employees.shift_id')
        ->get(['employees.name',
        'shifts.shift_name',
        'shifts.code',
        'shifts.shcedule_in',
        'shifts.shcedule_out',
        'shift_employees.date'
        ]);
    }
}
