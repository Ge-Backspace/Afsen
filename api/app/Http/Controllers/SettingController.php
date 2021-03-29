<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Position;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\ShiftEmployee;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getEmployee(Request $request)
    {
        $company_id = $request->company_id;
        return $this->resp($this->getEmployeeByUser($request->user_id)->whereHas('users', function($q) use($company_id){
            $q->where('role_id', '!=', 1)
            ->where('company_id', $company_id);
        }));
    }
    public function optionPosition(Request $request)
    {
        $option = Position::where('company_id', $request->company_id)->get();
        return $this->resp($option);
    }

    public function optionEmployee(Request $request)
    {
        $option = Employee::join('users', 'employees.user_id', '=', 'users.id')
        ->where('users.company_id', $request->company_id)
        ->get();
        return $this->resp($option);
    }

    public function optionShift(Request $request)
    {
        $option = Shift::where('company_id', $request->company_id)
        ->get();
        return $this->resp($option);
    }

    public function optionCuti(Request $request)
    {
        $option = Cuti::where('company_id', $request->company_id)
        ->get();
        return $this->resp($option);
    }

    public function optionShiftEmployee(Request $request)
    {
        $option = ShiftEmployee::join('shifts as s', 'shift_employees.shift_id', '=', 's.id')
        ->where('shift_employees.employee_id', $request->employee_id)
        ->get(['shift_employees.id as id', 'shift_employees.date', 's.shift_name', 's.code', 's.schedule_in', 's.schedule_out']);
        return $this->resp($option);
    }
}
