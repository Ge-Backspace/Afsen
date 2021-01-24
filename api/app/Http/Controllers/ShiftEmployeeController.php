<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Shift;
use App\Models\ShiftEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShiftEmployeeController extends Controller
{
    public function getTodayShiftEmployee(Request $request)
    {
        $employee = $this->getEmployeeByUser($request->user_id);
        $shiftEmployee = ShiftEmployee::where('employee_id', $employee->id)
        ->whereDate('date', '=', Carbon::today())
        ->first();
        $getTodayShiftEmployee = null;
        if ($shiftEmployee) {
            $shiftId = $shiftEmployee->shift_id;
            $getTodayShiftEmployee = Shift::find($shiftId);
        }
        return $this->resp($getTodayShiftEmployee);
    }

    public function getShiftEmployee(Request $request)
    {
        return $this->getPaginate(ShiftEmployee::join('shifts', 'shift_employees.shift_id', '=', 'shifts.id')
        ->where('employee_id', $request->employee_id), $request,['shifts.code']);
    }

    public function getCompanyShiftEmployee(Request $request)
    {
        return $this->getPaginate(ShiftEmployee::join('employees', 'shift_employees.employee_id', '=', 'employees.id')
        ->where('company_id', $request->company_id)
        , $request, ['employees.name']);
    }

    public function addShiftEmployee(Request $request)
    {
        $input = $request->only(['company_id', 'employee_id', 'shift_id', 'date']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'date' => 'required|date'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Shift Employee', false, 401);
        }
        $addShiftEmployee = ShiftEmployee::create($input);
        return $this->resp($addShiftEmployee);
    }

    public function updateShiftEmployee(Request $request, $id)
    {
        $shiftEmployee = ShiftEmployee::find($id);
        if (!$shiftEmployee) {
            return $this->resp(null, 'Shift Employee Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['company_id', 'employee_id', 'shift_id', 'date']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'date' => 'required|date'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Update Shift Employee', false, 401);
        }
        $updateShiftEmployee = $shiftEmployee->update($input);
        return $this->resp($updateShiftEmployee);
    }

    public function deleteShiftEmployee($id)
    {
        $shiftEmployee = ShiftEmployee::find($id);
        if (!$shiftEmployee) {
            return $this->resp(null, 'Shift Employee Tidak Ditemukan', false, 406);
        }
        $shiftEmployee->delete();
        return $this->resp();
    }
}
