<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getPaginate(Employee::rightJoin('users', 'employees.user_id', '=', 'users.id')
        ->orderBy('users.id', 'DESC')
        , $request, [
            'users.username', 'users.email', 'employees.name'
        ]);
    }

    public function user()
    {
        $user = JWTAuth::user();
        return $this->resp($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUserEmployee(Request $request)
    {
        $input = $request->only([
            'username', 'email', 'password', 'company_id', 'aktif', 'admin', 'name'
        ]);
        $validator = Validator::make($input, [
            'name' => 'required|string|min:4|max:100',
            'username' => 'required|string|min:5',
            'email' => 'required|string',
            'password' => 'required|min:8',
            'company_id' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $emailCheck = User::where('email', $input['email'])->first();
        $usernameCheck = User::where('username', $input['username'])->first();
        if($emailCheck) {
            return $this->resp(null, 'Email Sudah Digunakan', false, 406);
        } else if($usernameCheck) {
            return $this->resp(null, 'Username Sudah Digunakan', false, 406);
        } else {
            $inputUser = $request->only([
                'username', 'email', 'password', 'company_id', 'aktif', 'admin'
            ]);
            $password = Hash::make($input['password']);
            Arr::set($inputUser, 'password', $password);
            $user = User::create($inputUser);
            $inputEmployee = [
                'user_id' => $user->id,
                'name' => $input['name'],
            ];
            Arr::add($inputEmployee, 'user_id', $user->id);
            $employee = Employee::create($inputEmployee);
            return $this->resp([$input, $employee, $user]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find_user = User::find($id);

        $user = $find_user->with('companies')->get();

        if(!$find_user){
            return $this->resp(null, 'Data User Tidak Ada', false, 406);
        }else{
            return $this->resp($user);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return $this->resp(null, 'User Tidak Ditemukan', false, 406);
        }
        $input = $request->only([
            'username', 'email', 'admin', 'aktif'
        ]);
        $validator = Validator::make($input, [
            'username' => 'required|string',
            'email' => 'required|string',
            'admin' => 'required|numeric',
            'aktif' => 'required|numeric'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Employee', false, 401);
        }
        $update = $user->update($input);
        return $this->resp($update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $employee = Employee::where('user_id', $user->id)->first();
        if (!$user) {
            return $this->resp(null, 'User Tidak Ditemukan', false, 406);
        }
        $employee->delete();
        $user->delete();
        return $this->resp();
    }
}
