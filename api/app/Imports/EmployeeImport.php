<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        User::create([
            'company_id' => $this->company_id,
            'username' => $row[1],
            'email' => $row[2],
            'password' => $row[3],
            'aktif' => $row[8],
            'admin' => $row[9]
        ]);
        return Employee::create([
            'name' => $row[0],
            'nip' => $row[4],
            'position_id' => $row[5],
            'kontak' => $row[6],
            'status' => $row[7]
        ]);
    }
}
