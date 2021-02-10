<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Variable;
use App\Models\Checkin;
use App\Models\Companies;
use App\Models\Employee;
use App\Models\Office;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Spatie\Geocoder\Geocoder;

class Controller extends BaseController
{
    /**
     * resp
     *
     * @param  mixed $data
     * @param  mixed $success
     * @param  mixed $message
     * @param  mixed $merge
     * @param  mixed $status_code
     * @return void
     */
    public function resp($data = null, $message = Variable::SUCCESS, $success = true, $status_code = 200)
    {
        $result = [
            'success' => $success,
            'message' => $message,
            'code' => $status_code,
            'data' => $data
        ];
        return response()->json($result, $status_code);
    }

    /**
     * respMerge
     *
     * @param  mixed $data
     * @param  mixed $success
     * @param  mixed $message
     * @param  mixed $meta
     * @return void
     */
    public function respMerge($data = null, $message = Variable::SUCCESS, $success = true, $status_code = 200)
    {
        $result = collect([
            'success' => $success,
            'message' => $message,
            'code' => $status_code,
        ]);
        $result = $result->merge($data);
        return response()->json($result);
    }

    /**
     * getData
     *
     * @param  mixed $model
     * @param  mixed $request
     * @param  mixed $filterable
     * @return void
     */
    public function getData($model, $request, $filterable = [])
    {
        $model = $model->where(function($query)use($filterable, $request){
            foreach($filterable as $column){
                $query->orWhereRaw("CONCAT($column, '')  LIKE ?", ['%' . $request->search . '%']);
            }
        });

        return $this->resp($model->get());
    }

    /**
     * getPaginate
     *
     * @param  mixed $model
     * @param  mixed $request
     * @return void
     */
    public function getPaginate($model, $request, $filterable = [])
    {
        $model = $model->where(function($query)use($filterable, $request){
            foreach($filterable as $column){
                $query->orWhereRaw("CONCAT($column, '')  LIKE ?", ['%' . $request->search . '%']);
            }
        });

        $limit = $request->has('limit') ? (int) $request->limit : 10;
        return $this->respMerge($model->paginate($limit)->appends($request->except('page')));
    }

    /**
     * storeData
     *
     * @param  mixed $model
     * @param  mixed $rules
     * @param  mixed $input
     * @param  mixed $single_file
     * @param  mixed $multiple_files
     * @return void
     */
    public function storeData($model, $rules, $input, $single_file = [], $multiple_files = [])
    {
        $validator = Validator::make($input, $rules, Helper::messageValidation());

        if($validator->fails()){
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), Variable::FAILED, false, 406);
        }

        if(!empty($single_file)){
            $storeFile = Helper::storeFile('store', $single_file['type'], $single_file['field'], request());
            if($storeFile){
                $input['id_file'] = $storeFile;
            } else {
                return $this->resp(null, Variable::FAILED_UPLOAD, false, 400);
            }
        }

        $model = $model::create($input);

        if(!empty($multiple_files)){
            foreach($multiple_files as $key => $d_file){
                Helper::storeFile('store', $d_file['type'], [$d_file['field'], $key], request(), $model, true);
            }
        }

        if($model){
            return $this->resp($model);
        }
        return $this->resp(null, Variable::FAILED, false);
    }

    /**
     * updateData
     *
     * @param  mixed $model
     * @param  mixed $rules
     * @param  mixed $input
     * @param  mixed $single_file
     * @param  mixed $multiple_files
     * @return void
     */
    public function updateData($model, $rules, $input, $single_file = [], $multiple_files = [])
    {
        $validator = Validator::make($input, $rules, Helper::messageValidation());

        if($validator->fails()){
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), Variable::FAILED, false, 406);
        }

        if(!$model){
            return $this->resp(null, Variable::NOT_FOUND, false, 404);
        }

        if(!empty($single_file)){
            $storeFile = Helper::storeFile('update', $single_file['type'], $single_file['field'], request(), $model);
            if(!$storeFile){
                return $this->resp(null, Variable::FAILED_UPLOAD, false, 400);
            }
        }

        if(!empty($multiple_files)){
            Helper::clearMultiFile($model, $multiple_files[0]['type']);
            foreach($multiple_files as $d_file){
                Helper::storeFile('update', $d_file['type'], $d_file['field'], request(), $model, true);
            }
        }

        if($model->update($input)){
            return $this->resp($model);
        }
        return $this->resp(null, Variable::FAILED, false);
    }

    /**
     * showData
     *
     * @param  mixed $model
     * @return void
     */
    public function showData($model)
    {
        if($model){
            return $this->resp($model);
        } else {
            return $this->resp(null, Variable::NOT_FOUND, false, 404);
        }
    }

    /**
     * deleteData
     *
     * @param  mixed $model
     * @return void
     */
    public function deleteData($model)
    {
        if($model){
            $model->delete();
            return $this->resp();
        } else {
            return $this->resp(null, Variable::NOT_FOUND, false, 404);
        }
    }

    public function distance($lat1, $lon1, $lat2, $lon2) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;

            return ($miles * 1.609344);
        }
    }

    public function getCompanyByEmployee($employee_id){
        $employee = Employee::find($employee_id);
        $user = User::find($employee->user_id);
        $company = Companies::find($user->company_id);
        return $company;
    }

    public function getEmployeeByUser($user_id)
    {
        $employee = Employee::where('user_id', $user_id)->first();
        return $employee;
    }

    public function checkCheckin($employee_id)
    {
        $checkChekinToday = Checkin::where('employee_id', $employee_id)
        ->whereDate('checkin_time', '=', Carbon::today())->first();
        return $checkChekinToday;
    }

    public function checkCheckout($employee_id)
    {
        $checkChekoutToday = Checkin::where('employee_id', $employee_id)
        ->whereDate('checkout_time', '=', Carbon::today())->first();
        return $checkChekoutToday;
    }

    public function getAddress($lat, $lng){
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'IN'));
        $address = $geocoder->getAddressForCoordinates($lat, $lng);
        return $address;
    }

    public function getNearestOffice($employee_id, $lat, $lng)
    {
        $employee = Employee::find($employee_id);
        $user = User::find($employee->user_id);
        $office = Office::where('company_id', $user->company_id)->get();
        $distance = [];
        foreach ($office as $key => $location) {
            $a = $lat - $location['lat'];
            $b = $lng - $location['lng'];
            $distance = sqrt(($a**2) + ($b**2));
            $distances[$key] = $distance;
        }
        asort($distances);
        $closest = $office[key($distances)];
        return $closest;
    }

    public function getCenter($coordinates)
    {
        $count_coords = count($coordinates);
        $xcos=0.0;
        $ycos=0.0;
        $zsin=0.0;
        foreach ($coordinates as $lnglat)
        {
            $lat = $lnglat['lat'] * pi() / 180;
            $lon = $lnglat['lng'] * pi() / 180;
            $acos = cos($lat) * cos($lon);
            $bcos = cos($lat) * sin($lon);
            $csin = sin($lat);
            $xcos += $acos;
            $ycos += $bcos;
            $zsin += $csin;
        }
        $xcos /= $count_coords;
        $ycos /= $count_coords;
        $zsin /= $count_coords;
        $lon = atan2($ycos, $xcos);
        $sqrt = sqrt($xcos * $xcos + $ycos * $ycos);
        $lat = atan2($zsin, $sqrt);
        $center = array($lat * 180 / pi(), $lon * 180 / pi());
        return $center;
    }
}
