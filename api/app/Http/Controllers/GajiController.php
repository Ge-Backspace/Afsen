<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Gaji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\GajiImport;
use App\Exports\GajiExport;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{
    public function getCompanyGaji(Request $request)
    {
        return $this->getPaginate(Gaji::join('employees as e', 'gajis.employee_id', '=', 'e.id')
        ->join('positions as p', 'e.position_id', '=', 'p.id')
        ->where('p.company_id', $request->company_id)
        ->select(DB::raw('gajis.*, e.*, p.position_name, p.group, gajis.id as id'))
        ->orderBy('gajis.id', 'DESC')
        ,$request,[
            'e.name', 'gajis.gaji'
        ]);
    }

    public function addGaji(Request $request)
    {
        $input = $request->only(['company_id' ,'employee_id', 'gaji']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'gaji' => 'required|numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Gaji', false, 401);
        }
        $employee = Employee::find($input['employee_id'])->join('users as u', 'employees.user_id', '=', 'u.id');
        $gaji = Gaji::where('employee_id', $input['employee_id'])->first();
        if (!$employee) {
            return $this->resp(null, 'Data Employee Tidak Ditemukan', false, 406);
        } elseif($employee->company_id != $request->company_id){
            return $this->resp(null, 'Data Employee Tidak Ditemukan', false, 406);
        } elseif ($gaji) {
            return $this->resp(null, 'Data Gaji Sudah Ada Di Employee Tersebut', false, 406);
        }
        $add = Gaji::create([
            'employee_id' => $input['employee_id'],
            'gaji' => $input['gaji']
        ]);
        return $this->resp($add);
    }

    public function updateGaji(Request $request, $id)
    {
        $input = $request->only(['company_id' ,'employee_id', 'gaji']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'gaji' => 'required|numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Gaji', false, 401);
        }
        $employee = Employee::find($input['employee_id']);
        $table = Gaji::find($id)->join('users as u', 'employees.user_id', '=', 'u.id');;
        if (!$employee) {
            return $this->resp(null, 'Data Employee Tidak Ditemukan', false, 406);
        } elseif($employee->company_id != $request->company_id){
            return $this->resp(null, 'Data Employee Tidak Ditemukan', false, 406);
        } elseif (!$table) {
            return $this->resp(null, 'Data Gaji Tidak Ditemukan', false, 406);
        }
        $update = $table->update([
            'employee_id' => $input['employee_id'],
            'gaji' => $input['gaji']
        ]);
        return $this->resp($update);
    }

    public function deleteGaji($id)
    {
        $gaji = Gaji::find($id);
        if (!$gaji) {
            return $this->resp(null, 'Data Gaji Tidak Ditemukan', false, 406);
        }
        $delete = $gaji->delete();
        return $this->resp($delete);
    }

    public function importGaji(Request $request)
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
            $import = Excel::import(new GajiImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportCuti(Request $request)
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
        return Excel::download(new GajiExport($request->company_id), 'gaji.' . $type, $as);
    }
}
