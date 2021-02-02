<?php

namespace App\Exports;

use App\Models\CutiPermission;
use Maatwebsite\Excel\Concerns\FromCollection;

class CutiEmployeeExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return CutiPermission::join('employees', 'cuti_permissions.employee_id', '=', 'employees.id')
        ->join('cutis', 'cuti_permissions.cuti_id', '=', 'cutis.id')
        ->where('cutis.company_id', $this->company_id)
        ->where('cuti_permissions.status_id', 1)
        ->get(['employees.name', 'cutis.cuti_name', 'cutis.code', 'cuti_permissions.start_date', 'cuti_permissions.start_date']);
    }
}
