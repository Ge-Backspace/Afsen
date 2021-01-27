<?php

namespace App\Exports;

use App\Models\Checkin;
use Maatwebsite\Excel\Concerns\FromCollection;

class CheckinExport implements FromCollection
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }
    public function collection()
    {
        return Checkin::join('users', 'users.company_id', '=', 'companies.id')
        ->join('employees', 'employees.user_id', '=', 'users.id')
        ->where('companies.id', $this->company_id)
        ->get(['employees.name', 'checkin_time', 'checkout_time']);
    }
}
