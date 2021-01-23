<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Checkin;
use App\Models\Companies;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Geocoder\Geocoder;

class CheckinController extends Controller
{
    public function index(Request $request)
    {
        $checkin = DB::table('checkins')
        ->join('users', 'checkins.user_id', '=', 'users.id')
        ->where('company_id', $request->company_id)
        ->whereDate('checkin_time', '=', Carbon::today())
        ->orderBy('checkins.id', 'desc');

        return $this->getPaginate($checkin, $request, [
            'name',
            'checkin_time',
            'checkout_time',
        ]);
    }

    public function checkin(Request $request){
        $input = $request->only([
            'user_id', 'lat', 'lng'
        ]);

        $rules = [
            'user_id' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required'
        ];

        $validator = Validator::make ($input, $rules ,Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }

        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'IN'));

        $user_id = $input['user_id'];
        $lat = $input['lat'];
        $lng = $input['lng'];
        $address = $geocoder->getAddressForCoordinates($lat, $lng);
        $company = Companies::find(User::where('id', $user_id)
                                ->get('company_id'))->first();
        $check_account = User::find($user_id);

        if(!$check_account){
            return $this->resp($request->all(), 'Akun tidak terdaftar', false, 406);
        }

        $distcance = $this->distance($lat, $lng, $company->lat, $company->lng);
        // if($distcance >= 1){
        //     return $this->resp([$distcance, $request->lat, $request->lng, $company->lat, $company->lng], 'Jarak untuk Checkin tidak boleh Lebih dari 1 Km dari kantor', false, 406);
        // }

        $check_checkins = Checkin::where('employee_id', $request->employee_id)->whereDate('checkin_time', '=', Carbon::today())->first();

        if($check_checkins){
            return $this->resp(null, 'Anda Sudah Check In Hari Ini', false, 406);
        }

        $checkins = Checkin::create([
            'user_id' => $user_id,
            'checkin_time' => Carbon::now(),
            'lat' => $lat,
            'lng' => $lng,
            'address' => $address['formatted_address']
        ]);

        return $this->resp($checkins);
    }

    public function checkout(Request $request){
        $input = $request->only([
            'user_id', 'lat', 'lng'
        ]);

        $rules = [
            'user_id' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required'
        ];

        $validator = Validator::make ($input, $rules ,Helper::messageValidation());

        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()->getMessages()), false, 406);
        }

        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'IN'));

        $user_id = $input['user_id'];
        $lat = $input['lat'];
        $lng = $input['lng'];
        $company = Companies::find(User::where('id', $user_id)
                                ->get('company_id'))->first();
        $check_account = User::find($user_id);

        if(!$check_account){
            return $this->resp(null, 'Akun Tidak Terdaftar', false, 406);
        }

        $distcance = $this->distance($lat, $lng, $company->lat, $company->lng);
        if($distcance >= 1){
            return $this->resp([$distcance, $request->lat, $request->lng, $company->lat, $company->lng], 'Jarak untuk Checkout tidak boleh Lebih dari 1 Km dari kantor', false, 406);
        }

        $check_checkin = Checkin::where('user_id', $user_id)->whereDate('checkin_time', '=', Carbon::today())->first();
        $check_checkout = Checkin::where('user_id', $user_id)->whereDate('checkout_time','=', Carbon::today())->first();

        if(!$check_checkin){
            return $this->resp(null, 'Anda Belum Check In Hari Ini', false, 406);
        }elseif($check_checkout){
            return $this->resp(null, 'Anda Sudah Check Out Hari Ini', false, 406);
        }else{
            $checkout = Checkin::where('user_id', $user_id)->whereDate('checkin_time', Carbon::today())->update(['checkout_time' => Carbon::now()]);
            return $this->resp($checkout);
        }
    }

    public function check(Request $request){

        $id = $request->user_id;
        $check_user = User::find($id);
        $status = 0;
        if(!$check_user){
            return $this->resp(null, 'Akun Tidak Terdaftar', false, 406);
        }else{
            $check_checkins = Checkin::where('user_id', $id)->whereDate('checkin_time', '=', Carbon::today())->first();
            if (!$check_checkins){
                return $this->resp($status, 'Anda Belum Check In Hari Ini');
            }else{
                $check_checkout = Checkin::where('user_id', $id)->whereDate('checkout_time', '=', Carbon::today())->first();
                if(!$check_checkout){
                    $status = 1;
                    return $this->resp($status, 'Anda Sudah Check In Hari Ini');
                }else {
                    $status = 2;
                    return $this->resp($status, 'Anda Sudah Check Out Hari Ini');
                }
            }
        }
    }
}
