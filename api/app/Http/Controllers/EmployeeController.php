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
        return $this->getPaginate(Employee::leftJoin('positions', 'employees.position_id', '=', 'positions.id'), $request, [
            'employees.name', 'positions.position'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addEmployee(Request $request)
    {
        $validator = Validator::make($request->only(['company_id', 'name', 'user_id']), [
            'company_id' => 'required|numeric',
            'name' => 'required|string|min:4|max:100',
            'user_id' => 'required|numeric'
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
        $input = $request->only(['name', 'nip', 'position_id']);
        $employee = Employee::find($id);
        $update = $employee->update($input);

        return $this->resp($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteEmployee($id)
    {
        Employee::find($id)->delete();
        return $this->resp();
    }
}
