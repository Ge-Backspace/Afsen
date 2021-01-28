<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    protected $company_id;

    function __construct($company_id) {
            $this->company_id = $company_id;
    }

    public function model(array $row)
    {
        $user = User::create([
            'company_id' => $this->company_id,
            'username' => $row['username'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'aktif' => $row['aktif'],
            'admin' => $row['admin']
        ]);
        return Employee::create([
            'name' => $row['name'],
            'user_id' => $user->id,
            'nip' => $row['nip'],
            'position_id' => $row['position_id'],
            'kontak' => $row['kontak'],
            'status' => $row['status']
        ]);
    }
}
