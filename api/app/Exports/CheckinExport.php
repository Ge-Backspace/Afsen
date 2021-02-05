<?php

namespace App\Exports;

use App\Models\Checkin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class CheckinExport implements FromCollection, WithHeadings, WithEvents
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
                $event->sheet->getStyle('A1:D1')->applyFromArray($styleArray);
            },
        ];
    }

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Checkin::join('employees as e', 'checkins.employee_id', '=', 'e.id')
        ->join('users as u', 'e.user_id', '=', 'u.id')
        ->where('u.company_id', $this->company_id)
        ->get(['e.name', 'checkins.checkin_time', 'checkins.checkout_time', 'checkins.address']);
    }

    public function headings(): array
    {
        return [
        'name',
        'checkin',
        'chekout',
        'address'
        ];

    }
}
