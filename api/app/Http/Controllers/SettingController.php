<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Position;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Http\Request;

class SettingController extends Controller
{
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
}
