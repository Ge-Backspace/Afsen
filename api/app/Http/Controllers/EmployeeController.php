<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
use App\Imports\EmployeeImport;
use App\Exports\EmployeeExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
            Employee::join('positions', 'employees.position_id', '=', 'positions.id')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->where('users.company_id', $request->company_id)
            , $request, [
                'employees.name', 'positions.position_name'
            ]);

        // Example
        // select * from employees left join users on employees.user_id = users.id
        // join positions on employees.position_id = positions.id
        // where employees.company_id = 1
    }

    public function addEmployee(Request $request)
    {
        $input = $request->only([
            'company_id', 'name', 'username', 'email', 'password', 'nip', 'status', 'position_id', 'kontak',
        ]);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'name' => 'required|string|min:4|max:100',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required|boolean',
            'nip' => 'string',
            'kontak' => 'numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $companyCheck = Companies::find($input['company_id']);
        if(!$companyCheck){
            return $this->resp($request->input(), 'Company Tidak Ditemukan', false, 406);
        }
        $inputEmployee = $request->only(['name', 'position_id', 'status', 'kontak', 'nip']);
        $user = User::Create([
            'company_id' => $input['company_id'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password'])
        ]);
        $employee = Employee::create([
            'user_id' => $user->id,
            'name' => $inputEmployee['name'],
            'position_id' => $inputEmployee['position_id'],
            'status' => $inputEmployee['status'],
            'nip' => $inputEmployee['nip'],
            'kontak' => $inputEmployee['kontak'],
        ]);
        return $this->resp([$input, $user, $employee]);
    }

    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee)
        {
            return $this->resp(null, 'Employee Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['name', 'nip', 'position_id', 'kontak', 'status']);
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'nip' => 'required|string',
            'position_id' => 'required|numeric',
            'status' => 'required|boolean',
            'kontak' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Update Employee', false, 401);
        }
        $editEmployee = $employee->update($input);
        return $this->resp($editEmployee);
    }

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        if(!$employee)
        {
            return $this->resp(null, 'Employee Tidak Ditemukan', false, 406);
        }
        $employee->delete();
        return $this->resp();
    }

    public function importEmployee(Request $request)
    {
        $validator = Validator::make($request->only(['file']), [
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
