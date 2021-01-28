<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Employee::join('positions', 'positions.id', '=', 'employees.position_id')
        ->where('position.company_id', $this->company_id)
        ->get(['name', 'nip', 'kontak', 'status', 'positions.position_name']);
    }

    public function headings(): array
    {
        return [
            'name',
        'nip',
        'kontak',
        'status',
        'position'
        ];
        
    }
}
