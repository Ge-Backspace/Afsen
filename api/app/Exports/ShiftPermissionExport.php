<?php

namespace App\Exports;

use App\Models\ShiftPermission;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShiftPermissionExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return ShiftPermission::join('employees as e1', 'shift_permissions.employee1_id', '=', 'e1.id')
        ->join('employees as e2', 'shift_permissions.employee2_id', '=', 'e2.id')
        ->join('shift_employees as se1', 'shift_permissions.shift_employee1_id', '=', 'se1.id')
        ->join('shift_employees as se2', 'shift_permissions.shift_employee2_id', '=', 'se2.id')
        ->join('shifts as s1', 'se1.shift_id', '=', 's1.id')
        ->join('shifts as s2', 'se2.shift_id', '=', 's2.id')
        ->where('s1.company_id', $this->company_id)
        ->get([
            'e1.name', 'se1.date', 's1.code', 's1.schedule_in', 's1.schedule_out',
            'e2.name', 'se2.date', 's2.code', 's2.schedule_in', 's2.schedule_out',
            'shift_permissions.status_id'
        ]);
    }
}
