<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function optionPosition(Request $request)
    {
        $position = Position::where('company_id', $request->company_id)->get();
        return $this->resp($position);
    }

    public function optionEmployee(Request $request)
    {
        $employee = Employee::join('users', 'employees.user_id', '=', 'users.id')
        ->where('users.company_id', $request->company_id)
        ->get();
        return $this->resp($employee);
    }

    public function optionShift(Request $request)
    {
        $shift = Shift::where('company_id', $request->company_id)
        ->get();
        return $this->resp($shift);
    }
}
