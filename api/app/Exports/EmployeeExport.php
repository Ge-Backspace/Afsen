<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeExport implements FromCollection, WithHeadings, WithEvents
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
        return Employee::join('positions', 'positions.id', '=', 'employees.position_id')
        ->where('positions.company_id', $this->company_id)
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
