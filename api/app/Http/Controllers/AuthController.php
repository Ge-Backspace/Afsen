<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Variable;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Geocoder\Geocoder;

class AuthController extends Controller
{
    public function registerCompany (Request $request){
        $rules = [
            'company_name' => 'required|string|min:4|max:50',
            'lat' => 'required',
            'lng' => 'required'
        ];
        $validator = Validator::make ($request->all(), $rules ,Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }

        $company_name = $request->company_name;
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'IN'));

        $lat = $request->lat;
        $lng = $request->lng;
        $company_name = $request->company_name;
        $address = $geocoder->getAddressForCoordinates($lat, $lng);

        $company_check = Companies::where('name', $company_name)->first();

        if($company_check){
            return $this->resp(null, 'Nama Company Sudah Terdaftar', false, 406);
        }else{
            $register_company = Companies::create([
                'name' => $company_name,
                'address' => $address['formatted_address'],
                'lat' => $lat,
                'lng' => $lng
            ]);
            return $this->resp($register_company);
        }
    }

    public function registerAccount (Request $request){
        $rules = [
            'name' => 'required|string|min:4|max:100',
            'username' => 'required|string|min:5|max:20',
            'email' => 'required',
            'password' => 'required',
            'company_id' => 'required'
        ];

        $validator = Validator::make ($request->all(), $rules, Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }

        $name = $request->name;
        $username = strtolower($request->username);
        $email = $request->email;
        $company_id = $request->company_id;
        $password = Hash::make($request->password);
        $company_id_check = Companies::find($company_id);

        if (!$company_id_check){
            return $this->resp(null, 'Company Tidak Ada', false, 406);
        }else{
            $check_account = User::where('email', $email)->orWhere('username', $username)->first();

            if($check_account){
                return $this->resp(null, 'Username Atau Email Sudah Ada', false, 406);
            }else{
                $register_account = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'username' => $username,
                    'company_id' => $company_id,
                    'admin' => true,
                    'aktif' => true,
                ]);
                return $this->resp($register_account);
            }
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
