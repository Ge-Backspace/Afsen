<?php

namespace App\Exports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShiftExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Shift::where('company_id', $this->company_id)
        ->get(['shift_name', 'code', 'schedule_in', 'schedule_out']);
    }
}
