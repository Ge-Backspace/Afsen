<?php

namespace App\Exports;

use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ShiftEmployeeExport implements FromCollection, WithHeadings, WithEvents
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
                $event->sheet->getStyle('A1:F1')->applyFromArray($styleArray);
            },
        ];
    }

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

    public function headings(): array
    {
        return [
        'Employee Name',
        'Shift Name',
        'Code',
        'Schedule In',
        'Schedule Out',
        'Date'
        ];

    }
}
