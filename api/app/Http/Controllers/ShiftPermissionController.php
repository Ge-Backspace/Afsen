<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Employee;
use App\Models\ShiftEmployee;
use App\Models\ShiftPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Exports\ShiftPermissionExport;
use App\Helpers\Variable;
use App\Imports\ShiftPermissionImport;
use Maatwebsite\Excel\Facades\Excel;

class ShiftPermissionController extends Controller
{
    public function getShiftPermission(Request $request)
    {
        $table = ShiftPermission::join('employees as e1', 'shift_permissions.employee1_id', '=', 'e1.id')
        ->join('employees as e2', 'shift_permissions.employee2_id', '=', 'e2.id')
        ->join('shift_employees as se1', 'shift_permissions.shift_employee1_id', '=', 'se1.id')
        ->join('shift_employees as se2', 'shift_permissions.shift_employee2_id', '=', 'se2.id')
        ->join('shifts as s1', 'se1.shift_id', '=', 's1.id')
        ->join('shifts as s2', 'se2.shift_id', '=', 's2.id');
        if ($request->user_id) {
            $table->where('e1.id', $request->user_id);
        } else {
            $table->where('s1.company_id', $request->company_id);
        }
        return $this->getPaginate(
            $table
            ->select(
                DB::raw('shift_permissions.*, shift_permissions.id as id,
                e1.name as name1, se1.date as date1, s1.code as code1, s1.schedule_in as schedule_in1, s1.schedule_out as schedule_out1,
                e2.name as name2, se2.date as date2, s2.code as code2, s2.schedule_in as schedule_in2, s2.schedule_out as schedule_out2
                '
            ))->orderBy('id', 'DESC')
        , $request,['e1.name', 'e2.name', 's1.code', 's2.code', 's1.schedule_in', 's2.schedule_in', 's1.schedule_out', 's2.schedule_out']);
    }

    public function addShiftPermission(Request $request)
    {
        $e1 = Employee::find($request->employee1_id);
        $e2 = Employee::find($request->employee2_id);
        $se1 = ShiftEmployee::find($request->shift_employee1_id);
        $se2 = ShiftEmployee::find($request->shift_employee2_id);
        if (!$e1) {
            return $this->resp(null, 'Employee 1 Tidak Ditemukan', false, 406);
        } elseif (!$e2){
            return $this->resp(null, 'Employee 2 Tidak Ditemukan', false, 406);
        } elseif (!$se1){
            return $this->resp(null, 'Shift Employee 1 Tidak Ditemukan', false, 406);
        } elseif (!$se2){
            return $this->resp(null, 'Shift Employee 2 Tidak Ditemukan', false, 406);
        } elseif ($se1->employee_id != $e1->id){
            return $this->resp(null, 'Employee Tidak 1 Sesuai Dengan Data Shift Employee', false, 406);
        } elseif ($se2->employee_id != $e2->id){
            return $this->resp(null, 'Employee Tidak 2 Sesuai Dengan Data Shift Employee', false, 406);
        }
        $input = $request->only('employee1_id', 'employee2_id', 'shift_employee1_id', 'shift_employee2_id', 'reason', 'file');
        return $this->storeData(new ShiftPermission, [
            'employee1_id' => 'required|numeric',
            'employee2_id' => 'required|numeric',
            'shift_employee1_id' => 'required|numeric',
            'shift_employee2_id' => 'required|numeric',
            'reason' => 'required|min:4|max:255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::SHPE,
            'field' => 'file',
        ]);
    }

    public function updateShiftPermission(Request $request, $id)
    {
        $e1 = Employee::find($request->employee1_id);
        $e2 = Employee::find($request->employee2_id);
        $se1 = ShiftEmployee::find($request->shift_employee1_id);
        $se2 = ShiftEmployee::find($request->shift_employee2_id);
        if (!$e1) {
            return $this->resp(null, 'Employee 1 Tidak Ditemukan', false, 406);
        } elseif (!$e2){
            return $this->resp(null, 'Employee 2 Tidak Ditemukan', false, 406);
        } elseif (!$se1){
            return $this->resp(null, 'Shift Employee 1 Tidak Ditemukan', false, 406);
        } elseif (!$se2){
            return $this->resp(null, 'Shift Employee 2 Tidak Ditemukan', false, 406);
        } elseif ($se1->employee_id != $e1->id){
            return $this->resp(null, 'Employee Tidak 1 Sesuai Dengan Data Shift Employee', false, 406);
        } elseif ($se2->employee_id != $e2->id){
            return $this->resp(null, 'Employee Tidak 2 Sesuai Dengan Data Shift Employee', false, 406);
        }
        $table = ShiftPermission::find($id);
        $input = $request->only('employee1_id', 'employee2_id', 'shift_employee1_id', 'shift_employee2_id', 'reason', 'file');
        return $this->updateData($table, [
            'employee1_id' => 'required|numeric',
            'employee2_id' => 'required|numeric',
            'shift_employee1_id' => 'required|numeric',
            'shift_employee2_id' => 'required|numeric',
            'reason' => 'required|min:5|max:255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::SHPE,
            'field' => 'file'
        ]);
    }

    public function deleteShiftPermission($id)
    {
        $table = ShiftPermission::find($id);
        return $this->deleteData($table);
    }

    public function changeStatusShiftPermission(Request $request, $id)
    {
        $table = ShiftPermission::find($id);
        if (!$table) {
            return $this->resp(null, 'Permission Shift Tidak Ditemukan', false, 406);
        } elseif ($table->status_id != 0) {
            return $this->resp(null, 'Status Permission Shift Sudah Diubah', false, 406);
        }
        $s['status_id'] = 2;
        if ($request->status == 1) {
            $s['status_id'] = 1;
            $shift1 = ShiftEmployee::find($table->shift_employee1_id);
            $shift2 = ShiftEmployee::find($table->shift_employee2_id);
            $shift1->update(['employee_id' => $table->employee2_id]);
            $shift2->update(['employee_id' => $table->employee1_id]);
        }
        $update = $table->update($s);
        return $this->resp($update);
    }

    public function importShiftPermission(Request $request)
    {
        $validator = Validator::make($request->only(['company_id', 'file']), [
            'company_id' => 'required',
            'file' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Import Excel', false, 401);
        }
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import(new ShiftPermissionImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportShiftPermission(Request $request)
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
            $type = 'pdf';
            $as = \Maatwebsite\Excel\Excel::DOMPDF;
        }
        return Excel::download(new ShiftPermissionExport($request->company_id), 'shift_permissions.' . $type, $as);
    }
}
