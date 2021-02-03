<?php

namespace App\Exports;

use App\Models\ShiftPermission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ShiftPermissionExport implements FromCollection, WithHeadings, WithEvents
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
        return ShiftPermission::join('employees as e1', 'shift_permissions.employee1_id', '=', 'e1.id')
        ->join('employees as e2', 'shift_permissions.employee2_id', '=', 'e2.id')
        ->join('shift_employees as se1', 'shift_permissions.shift_employee1_id', '=', 'se1.id')
        ->join('shift_employees as se2', 'shift_permissions.shift_employee2_id', '=', 'se2.id')
        ->join('shifts as s1', 'se1.shift_id', '=', 's1.id')
        ->join('shifts as s2', 'se2.shift_id', '=', 's2.id')
        ->where('s1.company_id', $this->company_id)
        ->get([
            'e1.name as name1',
            'e2.name as name2',
            'se1.date as date1',
            'se2.date as date2',
            's1.code as code1',
            's2.code as code2',
            's1.schedule_in as sci1',
            's2.schedule_in as sci2',
            's1.schedule_out as sco1',
            's2.schedule_out as sco2',
            'shift_permissions.status_id'
        ]);
    }


    public function headings(): array
    {
        return [
        'Pengaju',
        'Pengganti',
        'Tanggal Shift Pengaju',
        'Tanggal Shift Pengganti',
        'Code Shift Pengaju',
        'Code Shift Pengganti',
        'Schedule In Pengaju',
        'Schedule In Pengganti',
        'Schedule Out Pengaju',
        'Schedule Out Pengganti',
        'Status Perizinan'
        ];

    }
}
