<?php

namespace App\Exports;

use App\Models\CutiPermission;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CutiPermissionExport implements FromCollection, WithHeadings, WithEvents
{
    protected $company_id;

    public function registerEvents(): array
    {
        $styleArray = [
            'font' => [
                'bold' => true,
            ]
        ];

        return [
            // Handle by a closure.
            AfterSheet::class => function (AfterSheet $event) use ($styleArray) {
                // $event->sheet->insertNewRowBefore(7, 2);
                // $event->sheet->insertNewColumnBefore('A', 2);
                $event->sheet->getStyle('A1:E1')->applyFromArray($styleArray);
            },
        ];
    }

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return CutiPermission::join('employees', 'cuti_permissions.employee_id', '=', 'employees.id')
        ->join('cutis', 'cuti_permissions.cuti_id', '=', 'cutis.id')
        ->where('cutis.company_id', $this->company_id)
        ->get(['employees.name', 'cutis.cuti_name', 'cutis.code', 'cuti_permissions.start_date', 'cuti_permissions.expired_date', 'cuti_permissions.status_id']);
    }

    public function headings(): array
    {
        return [
        'Employee Name',
        'Cuti Name',
        'Cuti Code',
        'Start Date',
        'Expired Date',
        'Status'
        ];

    }
}
