<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PositionExport implements FromCollection, WithHeadings, WithEvents
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
        return Position::where('company_id', $this->company_id)
        ->get(['position_name', 'group']);
    }

    public function headings(): array
    {
        return [
        'Position Name',
        'Group'
        ];
        
    }
}
