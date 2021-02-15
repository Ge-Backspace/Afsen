<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
use App\Imports\EmployeeImport;
use App\Exports\EmployeeExport;
use App\Helpers\Variable;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function getName (Request $request)
    {
        $name = Employee::where('user_id', $request->user_id)->first();
        return $this->resp($name->name);
    }

    public function getEmployee(Request $request)
    {
        return $this->getPaginate(
            Employee::leftJoin('positions', 'employees.position_id', '=', 'positions.id')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->where('users.company_id', $request->company_id)
            ->select(DB::raw('employees.*, positions.*, users.*, employees.id as id'))
            ->orderBy('employees.id', 'DESC')
            , $request, [
                'employees.name', 'positions.position_name'
            ]);
    }

    public function addEmployee(Request $request)
    {
        $input = $request->only([
            'company_id', 'name', 'username', 'email', 'password', 'nip', 'position_id', 'kontak',
            'status', 'admin', 'aktif'
        ]);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'name' => 'required|string|min:4|max:100',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'position_id' => 'required|numeric',
            'status' => 'required|boolean',
            'nip' => 'string',
            'kontak' => 'numeric',
            'admin' => 'required|boolean',
            'aktif' => 'required|boolean',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $companyCheck = Companies::find($input['company_id']);
        if(!$companyCheck){
            return $this->resp(null, 'Company '.Variable::NOT_FOUND, false, 406);
        }
        $inputUser = $request->only(['company_id','username', 'email', 'password', 'admin', 'aktif']);
        if(!empty($request->foto)){
            $storeFile = Helper::storeFile('store', Variable::USER, $request->foto, request());
            if($storeFile){
                $inputUser['file_id'] = $storeFile;
            } else {
                return $this->resp(null, Variable::FAILED_UPLOAD, false, 400);
            }
        }
        $password = Hash::make($inputUser['password']);
        $inputUser = Arr::set($inputUser, 'password', $password);
        $inputEmployee = $request->only(['name', 'position_id', 'status', 'nip', 'kontak']);
        $user = User::Create($inputUser);
        $employee = Employee::create([
            'user_id' => $user->id,
            'name' => $inputEmployee['name'],
            'position_id' => $inputEmployee['position_id'],
            'status' => $inputEmployee['status'],
            'nip' => $inputEmployee['nip'],
            'kontak' => $inputEmployee['kontak'],
        ]);
        return $this->resp([$user, $employee]);
    }

    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee)
        {
            return $this->resp(null, 'Employee Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['name', 'nip', 'position_id', 'kontak', 'status', 'admin', 'aktif']);
        $validator = Validator::make($input, [
            'name' => 'required|string|min:4|max:100',
            'nip' => 'string',
            'position_id' => 'required|numeric',
            'kontak' => 'numeric',
            'status' => 'required|boolean',
            'admin' => 'boolean',
            'aktif' => 'boolean'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Update Employee', false, 401);
        }
        $user = User::find($employee->user_id);
        $inputUser = $request->only([
            'admin', 'aktif'
        ]);
        if ($inputUser['admin'] | $inputUser['aktif']) {
            $user->update($inputUser);
        }
        $editEmployee = $employee->update($input);
        return $this->resp($editEmployee);
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $user = User::find($employee->id);
        if(!$employee && !$user)
        {
            return $this->resp(null, 'Employee Tidak Ditemukan', false, 406);
        }
        $user->delete();
        $employee->delete();
        return $this->resp();
    }

    public function importEmployee(Request $request)
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
            $import = Excel::import(new EmployeeImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportEmployee(Request $request)
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
        return Excel::download(new EmployeeExport($request->company_id), 'employees.' . $type, $as);
    }
}
