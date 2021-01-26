<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
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
            Employee::join('users AS u', 'employees.user_id', '=', 'u.id')
            ->join('positions AS p', 'employees.user_id', '=', 'p.id')
            ->where('u.company_id', $request->company_id)
            , $request, [
                'employees.name', 'p.position_name'
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
        $input = $request->only([
            'company_id', 'name', 'username', 'email', 'password', 'status'
        ]);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'name' => 'required|string|min:4|max:100',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required|boolean'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $companyCheck = Companies::find($input['company_id']);
        if(!$companyCheck){
            return $this->resp($request->input(), 'Company Tidak Ditemukan', false, 406);
        }
        $user = User::Create([
            'company_id' => $input['company_id'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password'])
        ]);
        $employee = Employee::create([
            'user_id' => $user->id,
            'name' => $input['name'],
            'status' => $input['status']
        ]);
        return $this->resp([$user, $employee]);
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
            return $this->resp(null, 'Employee Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['name', 'nip', 'position_id', 'status']);
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'nip' => 'required|string',
            'position_id' => 'required|numeric',
            'status' => 'required|boolean'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Update Employee', false, 401);
        }
        $editEmployee = $employee->update($input);
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
