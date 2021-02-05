<?php

namespace App\Exports;

use App\Models\Gaji;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class GajiExport implements FromCollection, WithHeadings, WithEvents
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
                $event->sheet->getStyle('A1:C1')->applyFromArray($styleArray);
            },
        ];
    }

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Gaji::join('employees as e', 'gajis.employee_id', '=', 'e.id')
        ->join('positions as p', 'e.position_id', '=', 'p.id')
        ->where('p.company_id', $this->company_id)
        ->get(['e.employee_name', 'p.position_name','p.group', 'gajis.gaji']);
    }

    public function headings(): array
    {
        return [
        'Position Name',
        'Group',
        'Gaji',
        ];

    }
}
