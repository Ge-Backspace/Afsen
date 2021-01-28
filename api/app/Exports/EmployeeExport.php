<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Employee::join('positions', 'positions.id', '=', 'employees.position_id')
        ->where('positions.company_id', $this->company_id)
        ->get(['name', 'nip', 'kontak', 'status', 'positions.position_name']);
    }
}
