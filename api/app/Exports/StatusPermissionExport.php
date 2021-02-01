<?php

namespace App\Exports;

use App\Models\StatusPermission;
use Maatwebsite\Excel\Concerns\FromCollection;

class StatusPermissionExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return StatusPermission::where('company_id', $this->company_id)
        ->get(['status_name', 'code']);
    }
}
