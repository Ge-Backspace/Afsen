<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Checkin;
use Carbon\Carbon;
use App\Exports\CheckinExport;
use App\Models\EarlyCheckout;
use App\Models\ShiftEmployee;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckinController extends Controller
{
    public function check(Request $request){
        $employee = $this->getEmployeeByUser($request->user_id);
        $checkCheckin = $this->checkCheckin($employee->id);
        $checkCheckout = $this->checkCheckout($employee->id);
        $status = ['status' => 0];
        if (!$checkCheckin) {
            return $this->resp($status, 'Anda Belum Check In Hari Ini');
        } elseif ($checkCheckin && !$checkCheckout) {
            $status = ['status' => 1];
            return $this->resp($status, 'Anda Sudah Check In Hari Ini');
        } elseif ($checkCheckout) {
            $status = ['status' => 2];
            return $this->resp($status, 'Anda Sudah Check Out Hari Ini');
        }
    }

    public function todayAttendance(Request $request)
    {
        $todayCheckin = Checkin::join('employees', 'checkins.employee_id', '=', 'employees.id')
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->where('users.company_id', $request->company_id)
        ->whereDate('checkin_time', '=', Carbon::today())
        ->select(DB::raw('employees.name, checkins.*, checkins.status as status'))
        ->orderBy('checkins.id', 'desc');
        return $this->getPaginate($todayCheckin, $request,['employees.name']);
    }

    public function attendance(Request $request)
    {
        $table = Checkin::join('employees as e', 'checkins.employee_id', '=', 'e.id')
        ->join('users as u', 'e.user_id', '=', 'u.id')
        ->where('u.company_id', $request->company_id)
        ->select(DB::raw('checkins.*, checkins.id as id, e.name'));
        return $this->getPaginate($table, $request, ['e.name']);
    }

    public function checkin(Request $request)
    {
        $input = $request->only(['request' ,'user_id', 'lat', 'lng']);
        $rules = [
            'request' => 'required',
            'user_id' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required'
        ];
        $validator = Validator::make ($input, $rules ,Helper::messageValidation());
        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()
            ->getMessages()), false, 406);
        }
        $employee = $this->getEmployeeByUser($request->user_id);
        $address = $this->getAddress($input['lat'], $input['lng']);
        $nearestOffice = $this->getNearestOffice($employee->id, $input['lat'], $input['lng']);
        $distcance = $this->distance($nearestOffice->lat, $nearestOffice->lng, $input['lat'], $input['lng']);
        $checkCheckin = $this->checkCheckin($employee->id);
        $checkCheckout = $this->checkCheckout($employee->id);
        $now = Carbon::now();
        if ($distcance > 9999999) {
            $message = 'Jarak untuk Checkin tidak boleh Lebih dari 1 Km dari kantor';
            if ($input['request'] == 2) {
                $message = 'Jarak untuk Checkout tidak boleh Lebih dari 1 Km dari kantor';
            }
            return $this->resp(['distance' => $distcance, 'nearest office' => $nearestOffice],
            $message, false, 406);
        } elseif ($input['request'] == 1) {
            if ($checkCheckin) {
                return $this->resp(null, 'Anda Sudah Checkin Hari Ini', false, 406);
            }
            $shiftEmployee = ShiftEmployee::join('shifts', 'shift_employees.shift_id', '=', 'shifts.id')
            ->where('employee_id', $employee->id)
            ->whereDate('date', $now)
            ->first();
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checkin Hari Ini', false, 406);
            }
            $status = 0;
            $schedule_in = Carbon::parse($shiftEmployee->schedule_in);
            if ($now > $schedule_in && $now <= $schedule_in->addMinute(15)) {
                $status = 1;
            }
            elseif ($now > $schedule_in && $now > $schedule_in->addMinute(15)) {
                $status = 2;
            }
            $checkin = Checkin::create([
                'employee_id' => $employee->id,
                'checkin_time' => Carbon::now(),
                'lat' => $input['lat'],
                'lng' => $input['lng'],
                'status' => $status,
                'address' => $address['formatted_address']
            ]);
            return $this->resp($checkin);
        } elseif ($input['request'] == 2){
            if ($checkCheckout) {
                return $this->resp(null, 'Anda Sudah Checkout Hari Ini', false, 406);
            }
            $shiftEmployee = ShiftEmployee::join('shifts', 'shift_employees.shift_id', '=', 'shifts.id')
            ->where('employee_id', $employee->id)
            ->whereDate('date', $now)
            ->first();
            $schedule_out = Carbon::parse($shiftEmployee->schedule_out);
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checout Hari Ini', false, 406);
            }
            if ($now < $schedule_out) {
                return $this->resp(['checkin' => $checkCheckin->id, 'schedule_out' => $shiftEmployee->schedule_out], 'Anda Checout Dibawah Shift Schedule Out', false, 409);
            }
            $checkout = $checkCheckin->update(['checkout_time' => Carbon::now()]);
            return $this->resp($checkout);
        }
    }

    public function earlyCheckout(Request $request, $id)
    {
        $checkin = Checkin::find($id);
        if(!$checkin)
        {
            return $this->resp(null, 'Data Checkin Tidak Ditemukan', false, 406);
        }
        if($checkin->checkout_time)
        {
            return $this->resp(null, 'Anda Sudah Checkout Hari Ini', false, 406);
        }
        $input = $request->only('reason');
        $validator = Validator::make($input, [
            'reason' => 'required|string'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Early Checkout', false, 401);
        }
        $input = Arr::add($input, 'checkin_id', $id);
        $checkout = $checkin->update(['checkout_time' => Carbon::now()]);
        $earlyC = EarlyCheckout::create($input);
        $earlyC = Arr::add($earlyC, 'checkout', $checkout);
        return $this->resp($earlyC);
    }

    public function exportCheckin(Request $request)
    {
        $validator = Validator::make($request->only(['user_id']), [
            'user_id' => 'required',
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
        return Excel::download(new CheckinExport($request->user_id), 'attendance.' . $type, $as);
    }

    public function exportAttendance(Request $request)
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
        return Excel::download(new CheckinExport($request->company_id), 'cuti_permissions.' . $type, $as);
    }
}
