<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Variable;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function registerCompany (Request $request){
        $input = $request->only(['company_name']);
        $rules = [
            'company_name' => 'required|string|min:4|max:50',
        ];
        $validator = Validator::make ($request->all(), $rules ,Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }
        $companyCheck = Companies::where('name', $input['company_name']);
        if($companyCheck){
            return $this->resp(null, 'Nama Company Sudah Terdaftar', false, 406);
        }else{
            $register_company = Companies::create([
                'name' => $input['company_name']
            ]);
            return $this->resp($register_company);
        }
    }

    public function registerAccount (Request $request){
        $input = $request->only(['name', 'username', 'email', 'password', 'company_id']);
        $rules = [
            'name' => 'required|string|min:4|max:100',
            'username' => 'required|string|min:5|max:20',
            'email' => 'required',
            'password' => 'required',
            'company_id' => 'required'
        ];
        $validator = Validator::make ($input, $rules, Helper::messageValidation());
        if($validator->fails()){
            return $this->resp(null, Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }
        $company = Companies::find($input['company_id']);
        $username = User::where('username', $input['username'])->first();
        $email = User::where('email', $input['email'])->first();
        if (!$company) {
            return $this->resp(null, 'Company Tidak Ditemukan', false, 406);
        } elseif ($username) {
            return $this->resp(null, 'Username Sudah Digunakan', false, 406);
        } elseif($email) {
            return $this->resp(null, 'Email Sudah Digunakan', false, 406);
        } else {
            $inputUser = User::create([
                'company_id' => $input['company_id'],
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password'])
            ]);
            $inputEmployee = Employee::create([
                'name' => $input['name'],
                'user_id' => $inputUser->id
            ]);
            return $this->resp([$inputUser, $inputEmployee]);
        }
    }

    public function login (Request $request){

        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|string',
            'password' => 'required|string'
        ], Helper::messageValidation());

        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), Variable::FAILED_LOGIN, false, 401);
        }

        // $username = User::where('username', $request->email)->first();
        // if($username){
        //     $request->request->email = $username->email;
        //     dd($request->request->email);
        // }

        $token = app('auth')->attempt($request->only('email', 'password'));
        if($token){
            return $this->resp([
                'token' => $token,
                'user' => JWTAuth::user()
            ]);
        }

        return $this->resp(null, Variable::LOGIN_NOT_MATCH, false, 401);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string'
        ], Helper::messageValidation());

        if($validator->fails()){
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), Variable::FAILED, false, 406);
        }
        $user = auth()->user();
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
            $user->save();
            return $this->resp(null, 'Berhasil Mengubah Password');
        }
        return $this->resp(null, 'Password Lama Salah', false, 406);

    }

    public function checkCompany(Request $request){
        $rules = [
            'company_name' => 'required|string'
        ];
        $validator = Validator::make ($request->all(), $rules ,Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }

        $company_name = $request->company_name;

        $company_check = Companies::where('name', $company_name)->first();

        if(!$company_check){
            return $this->resp($request->all(), 'Nama Company Tidak Ada', false, 406);
        }else{
            return $this->resp($company_check);
        }
    }
}
