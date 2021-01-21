<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployee(Request $request)
    {
        return $this->getPaginate(
            Employee::leftJoin('positions', 'employees.position_id', '=', 'positions.id')
            ->lefJoin('users', 'employees.user_id', '=', 'users.id')
            ->where('employees.company_id', $request->company_id), $request, [
                'employees.name', 'positions.name'
            ]);

        // Example
        // select * from employees left join users on employees.user_id = users.id
        // join positions on employees.position_id = positions.id
        // where employees.company_id = 1
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->only(['company_id', 'name', 'user_id','status']), [
            'company_id' => 'required|numeric',
            'name' => 'required|string|min:4|max:100',
            'user_id' => 'required|numeric',
            'status' => 'required|boolean'
        ], Helper::messageValidation());

        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if($user){
            return $this->resp($request->input(), 'Employee hanya boleh memiliki 1 user', false, 406);
        }
        $company_id = $request->company_id;
        $company = Companies::find($company_id);
        if(!$company){
            return $this->resp($request->input(), 'Company Tidak Terdaftar', false, 406);
        }
        $name = $request->name;
        $nip = $request->nip;
        $status = $request->status;
        if(!$user_id){
            $user_id = 0;
        }
        if(!$status){
            $status = 0;
        }
        $input = [
            'user_id' => $user_id,
            'company_id' => $company_id,
            'name' => $name,
            'nip' => $nip,
            'satus' => $status
        ];
        $addEmployee = Employee::create($input);

        return $this->resp($addEmployee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee)
        {
            return $this->resp(null, 'Employee tidak ditemukan', false, 406);
        }
        $input = $request->only(['name', 'nip', 'position_id', 'status']);
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'nip' => 'required|string',
            'position_id' => 'required|numeric',
            'status' => 'required|boolean'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $editEmployee = $employee->update($input);
        $user = User::find($editEmployee->user_id);
        if($user->name != $editEmployee->name){
            $user->update($request->name);
        }
        return $this->resp($editEmployee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
}
