<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\CutiPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\CutiPermissionImport;
use App\Exports\CutiPermissionExport;
use App\Helpers\Variable;
use Maatwebsite\Excel\Facades\Excel;

class CutiPermissionController extends Controller
{
    public function getCutiPermission(Request $request)
    {
        return $this->getPaginate(
            CutiPermission::join('employees', 'cuti_permissions.employee_id', '=', 'employees.id')
            ->join('cutis', 'cuti_permissions.cuti_id', '=', 'cutis.id')
            ->where('cutis.company_id', $request->company_id)
            ->select(DB::raw('cuti_permissions.*, employees.*, cutis.*, cuti_permissions.id as id'))
            ->orderBy('cuti_permissions.id', 'DESC'), $request, ['employees.name', 'cutis.cuti_name', 'cutis.code']);
    }

    public function addCutiPermission(Request $request)
    {
        $input = $request->only('employee_id', 'cuti_id', 'start_date', 'expired_date', 'reason', 'file');
        return $this->storeData(new CutiPermission, [
            'employee_id' => 'required|numeric',
            'cuti_id' => 'required|numeric',
            'start_date' => 'required|date',
            'expired_date' => 'required|date',
            'reason' => 'required|min:5|max:255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::CTPE,
            'field' => 'file'
        ]);
    }

    public function updateCutiPermission(Request $request, $id)
    {
        $table = CutiPermission::find($id);
        $input = $request->only(['employee_id', 'cuti_id', 'start_date', 'expired_date']);
        return $this->updateData($table, [
            'employee_id' => 'required|numeric',
            'cuti_id' => 'required|numeric',
            'start_date' => 'required|date',
            'expired_date' => 'required|date',
            'reason' => 'required|min:5|max|255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::CTPE,
            'field' => 'file'
        ]);
    }

    public function deleteCutiPermission($id)
    {
        $table = CutiPermission::find($id);
        return $this->deleteData($table);
    }

    public function changeStatusCutiPermission(Request $request, $id)
    {
        $table = CutiPermission::find($id);
        if (!$table) {
            return $this->resp(null, 'Permission Cuti Tidak Ditemukan', false, 406);
        } elseif ($table->status_id != 0) {
            return $this->resp(null, 'Status Permission Cuti Sudah Diubah', false, 406);
        }
        $s['status_id'] = 2;
        if ($request->status == 1) {
            $s['status_id'] = 1;
        }
        $update = $table->update($s);
        return $this->resp($update);
    }

    public function importCutiPermission(Request $request)
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
            $import = Excel::import(new CutiPermissionImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportCutiPermission(Request $request)
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
        return Excel::download(new CutiPermissionExport($request->company_id), 'cuti_permissions.' . $type, $as);
    }
}
