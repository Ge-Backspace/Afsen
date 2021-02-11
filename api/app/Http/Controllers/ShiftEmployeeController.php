<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Shift;
use App\Models\ShiftEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\ShiftEmployeeImport;
use App\Exports\ShiftEmployeeExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


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
        return $this->getPaginate(
            ShiftEmployee::join('employees as e', 'e.id', '=', 'shift_employees.employee_id')
            ->join('shifts as s', 's.id', '=', 'shift_employees.shift_id')
            ->where('shift_employees.company_id', $request->company_id)
            ->select(DB::raw('shift_employees.*, e.*, s.*, shift_employees.id as id'))
            ->orderBy('shift_employees.id', 'ASC')
        , $request,['e.name', 's.shift_name', 's.code', 'date']);
    }

    public function addShiftEmployee(Request $request)
    {
        $input = $request->only(['company_id', 'employee_id', 'shift_id', 'start_date', 'end_date']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Shift Employee', false, 401);
        }
        $st = Carbon::parse($input['start_date']);
        $ed = Carbon::parse($input['end_date']);
        $add = [];
        for ($st; $st <= $ed; $st->addDay(1)) {
            $shiftEmployee = ShiftEmployee::where('employee_id', $input['employee_id'])
            ->whereDate('date', $st->format('Y-m-d'))->first();
            if ($shiftEmployee) {
                return $this->resp(null, 'Jadwal Shift Employee Sudah Ada Pada Tanggal Tersebut', false, 406);
            }
            $add[] = [
                'company_id' => $input['company_id'],
                'employee_id' => $input['employee_id'],
                'shift_id' => $input['shift_id'],
                'date' => $st->format('Y-m-d')
            ];
        }
        $addSE = ShiftEmployee::insert($add);
        return $this->resp($addSE);
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

    public function importShiftEmployee(Request $request)
    {
        $validator = Validator::make($request->only(['company_id','file']), [
            'company_id' => 'required',
            'file' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Import Excel', false, 401);
        }
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import(new ShiftEmployeeImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportShiftEmployee(Request $request)
    {
        $validator = Validator::make($request->only(['company_id']), [
            'company_id' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Export Document', false, 401);
        }
        $as = \Maatwebsite\Excel\Excel::XLSX;
        $type = 'xlsx';
        if($request->as == 'pdf'){
            $as = \Maatwebsite\Excel\Excel::DOMPDF;
            $type = 'pdf';
        }
        return Excel::download(new ShiftEmployeeExport($request->company_id), 'shift_employee.' . $type, $as);
    }
}
