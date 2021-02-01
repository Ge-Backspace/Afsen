<?php

namespace App\Exports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\FromCollection;

class CutiExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Cuti::where('company_id', $this->company_id)
        ->get(['cuti_name', 'code']);
    }
}
