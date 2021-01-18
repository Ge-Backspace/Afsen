<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Checkin;
use App\Models\Companies;
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
            'lat' => 'required|string',
            'lng' => 'required|string'
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

        if ($lat == 0 && $lng == 0){
            return $this->resp($request->all(), 'Lokasi tidak masuk', false, 406);
        } else {
            $company_lat = $company->lat;
            $company_lng = $company->lng;

            $theta = $lng - $company_lng;
            $dist = sin(deg2rad($lat)) * sin(deg2rad($company_lat)) +  cos(deg2rad($lat)) * cos(deg2rad($company_lat)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            $distcance = $miles * 1.609344;

            if($distcance >= 1){
                return $this->resp(null, 'Jarak untuk Checkin tidak boleh Lebih dari 1 Km dari kantor', false, 406);
            }
        }

        $check_checkins = Checkin::where('user_id', $user_id)->whereDate('checkin_time', '=', Carbon::today())->first();

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
            'lat' => 'required|string',
            'lng' => 'required|string'
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

        if ($lat == 0 && $lng == 0){
            return $this->resp($request->all(), 'Lokasi tidak masuk', false, 406);
        } else {
            $company_lat = $company->lat;
            $company_lng = $company->lng;

            $theta = $lng - $company_lng;
            $dist = sin(deg2rad($lat)) * sin(deg2rad($company_lat)) +  cos(deg2rad($lat)) * cos(deg2rad($company_lat)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            $distcance = $miles * 1.609344;

            if($distcance >= 1){
                return $this->resp(null, 'Jarak untuk Checkin tidak boleh Lebih dari 1 Km dari kantor', false, 406);
            }
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

    public function check(Request $id){

        $check_user = User::find($id);

        if(!$check_user){
            return $this->resp(null, 'Akun Tidak Terdaftar', false, 406);
        }else{
            $check_checkins = Checkin::where('user_id', $id)->whereDate('checkin', '=', Carbon::today())->first();
            if (!$check_checkins){
                return $this->resp(null, 'Anda Belum Check In Hari Ini');
            }else{
                $check_checkout = Checkin::where('user_id', $id)->whereDate('checkout', '=', Carbon::today())->first();
                if(!$check_checkout){
                    return $this->resp(null, 'Anda Sudah Check In Hari Ini');
                }else {
                    return $this->resp(null, 'Anda Sudah Check Out Hari Ini');
                }
            }
        }
    }
}
