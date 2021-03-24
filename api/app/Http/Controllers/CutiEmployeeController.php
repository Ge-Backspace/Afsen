<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\CutiPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\CutiEmployeeImport;
use App\Exports\CutiEmployeeExport;
use Maatwebsite\Excel\Facades\Excel;

class CutiEmployeeController extends Controller
{
    public function getCutiEmployee(Request $request)
    {
        $query = CutiPermission::join('employees', 'cuti_permissions.employee_id', '=', 'employees.id')
            ->join('cutis', 'cuti_permissions.cuti_id', '=', 'cutis.id');
        if ($request->user_id) {
            $employee = $this->getEmployeeByUser($request->user_id);
            $query->where('employee_id', $employee->id);
        } else {
            $query->where('cutis.company_id', $request->company_id);
        }
        return $this->getPaginate(
            $query
            ->where('cuti_permissions.status_id', 1)
            ->select(DB::raw('cuti_permissions.*, employees.*, cutis.*, cuti_permissions.id as id'))
            ->orderBy('cuti_permissions.id', 'DESC'), $request, ['employees.name', 'cutis.cuti_name', 'cutis.code']);
    }

    public function addCutiEmployee(Request $request)
    {
        $input = $request->only('employee_id', 'cuti_id', 'start_date', 'expired_date', 'status_id', 'reason', 'file');
        $validator = Validator::make($input, [
            'employee_id' => 'required|numeric',
            'cuti_id' => 'required|numeric',
            'start_date' => 'required|date',
            'expired_date' => 'required|date',
            'reason' => 'required|min:5|max:255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Cuti Permission', false, 401);
        }
        Arr::set($input, 'status_id', 1);
        $add = CutiPermission::create($input);
        return $this->resp($add);
    }

    public function updateCutiEmployee(Request $request, $id)
    {
        $table = CutiPermission::find($id);
        if (!$table) {
            return $this->resp(null, 'Permission Cuti Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['employee_id', 'cuti_id', 'start_date', 'expired_date', 'reason', 'file']);
        $validator = Validator::make($input, [
            'employee_id' => 'required|numeric',
            'cuti_id' => 'required|numeric',
            'start_date' => 'required|date',
            'expired_date' => 'required|date',
            'reason' => 'required|min:5|max:255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp([$input, Helper::generateErrorMsg($validator->errors()->getMessages())], 'Failed Edit Position', false, 406);
        }
        $update = $table->update($input);
        return $this->resp($update);
    }

    public function deleteCutiEmployee($id)
    {
        $table = CutiPermission::find($id);
        if (!$table) {
            return $this->resp(null, 'Permission Cuti Tidak Ditemukan', false, 406);
        }
        $table->delete();
        return $this->resp();
    }

    // public function changeStatusCutiPermission(Request $request, $id)
    // {
    //     $table = CutiPermission::find($id);
    //     if (!$table) {
    //         return $this->resp(null, 'Permission Cuti Tidak Ditemukan', false, 406);
    //     }
    //     $s['status_id'] = 2;
    //     if ($request->status == 1) {
    //         $s['status_id'] = 1;
    //     }
    //     $update = $table->update($s);
    //     return $this->resp($update);
    // }

    public function importCutiEmployee(Request $request)
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
            $import = Excel::import(new CutiEmployeeImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportCutiEmployee(Request $request)
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
        return Excel::download(new CutiEmployeeExport($request->company_id), 'cuti_employees.' . $type, $as);
    }
}
