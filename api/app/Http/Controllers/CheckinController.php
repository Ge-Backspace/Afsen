<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Checkin;
use Carbon\Carbon;
use App\Exports\CheckinExport;
use App\Helpers\Variable;
use App\Models\ShiftEmployee;
use App\Models\SpecialCheckin;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckinController extends Controller
{
    public function check(Request $request){
        $input = $request->only('user_id');
        $validator = Validator::make($input, [
            'user_id' => 'required|numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Check', false, 401);
        }
        $employee = $this->getEmployeeByUser($request->user_id);
        $checkCheckin = $this->checkCheckin($employee->id);
        $checkCheckout = $this->checkCheckout($employee->id);
        $schedule = $this->getScheduleToday($employee->id);
        if (!$schedule) {
            return $this->resp([
                'status' => 6,
                'description' => 'no schedule'
            ], "Anda Tidak Memiliki Schedule Hari Ini");
        }
        $now = Carbon::now()->format('H:i:s');
        $startday = Carbon::parse('06:00:00')->format('H:i:s');
        $schedule_in = Carbon::parse($schedule->schedule_in)->addMinutes(15)->format('H:i:s');
        $schedule_out = Carbon::parse($schedule->schedule_out)->format('H:i:s');
        $result = [
            'status' => 1,
            'description' => 'on'
        ];
        $message = 'Anda Belum Checkin Hari ini';
        if (!$checkCheckin && !$checkCheckout) {
            if ($now >= $startday) {
                if ($now > $schedule_in) {
                    $result = [
                        'status' => 2,
                        'description' => 'late'
                    ];
                } elseif ($now > $schedule_out) {
                    $result = [
                        'status' => 3,
                        'description' => 'absent'
                    ];
                }
            }
        } elseif ($checkCheckin && !$checkCheckout) {
            $message = "Anda Sudah Checkin Hari Ini";
            $result = [
                'status' => 4,
                'description' => 'present'
            ];
        } elseif ($checkCheckin && $checkCheckout) {
            $message = "Anda Sudah Checkout Hari Ini";
            $result = [
                'status' => 5,
                'description' => 'present'
            ];
        }
        return $this->resp($result, $message);
    }

    public function todayAttendance(Request $request)
    {
        $todayCheckin = Checkin::join('employees', 'checkins.employee_id', '=', 'employees.id')
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->join('positions', 'employees.position_id', '=', 'positions.id')
        ->where('users.company_id', $request->company_id)
        ->whereDate('checkin_time', '=', Carbon::today())
        ->select(DB::raw('employees.name, checkins.*, positions.position_name, checkins.status as status'))
        ->orderBy('checkins.id', 'desc');
        return $this->getPaginate($todayCheckin, $request,['employees.name']);
    }

    public function attendance(Request $request)
    {
        $table = Checkin::join('employees as e', 'checkins.employee_id', '=', 'e.id')
        ->join('users as u', 'e.user_id', '=', 'u.id');
        if ($request->user_id) {
            $table->where('e.id', $request->user_id);
        } else {
            $table->where('u.company_id', $request->company_id);
        }
        return $this->getPaginate($table->select(DB::raw('checkins.*, checkins.id as id, e.name')), $request, ['e.name']);
    }

    public function checkin(Request $request)
    {
        $input = $request->only(['request' ,'user_id', 'lat', 'lng']);
        $rules = [
            'request' => 'required',
            'user_id' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
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
        $shiftEmployee = ShiftEmployee::join('shifts', 'shift_employees.shift_id', '=', 'shifts.id')
        ->where('employee_id', $employee->id)
        ->whereDate('date', $now)
        ->first();
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
            $schedule_in = Carbon::parse($shiftEmployee->schedule_in);
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checkin Hari Ini', false, 406);
            }
            if ($now > $schedule_in) {
                return $this->resp(['status' => 0], 'Anda Checkin Diatas Shift Schedule In', false, 409);
            }
            $status = 0;
            $schedule_in = Carbon::parse($shiftEmployee->schedule_in)->addMinute(15);
            if ($now > $schedule_in && $now <= $schedule_in) {
                $status = 1;
            }
            elseif ($now > $schedule_in && $now > $schedule_in) {
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
            if (!$checkCheckin) {
                return $this->resp(null, 'Anda Belum Checkin Hari Ini', false, 406);
            }
            $schedule_out = Carbon::parse($shiftEmployee->schedule_out);
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checout Hari Ini', false, 406);
            }
            if ($now < $schedule_out) {
                return $this->resp(['checkin' => $checkCheckin->id, 'schedule_out' => $shiftEmployee->schedule_out, 'status' => 1], 'Anda Checout Dibawah Shift Schedule Out', false, 409);
            }
            $checkout = $checkCheckin->update(['checkout_time' => Carbon::now()]);
            return $this->resp($checkout);
        }
    }

    public function specialCheckin(Request $request)
    {
        $input = $request->only(['user_id', 'lat', 'lng', 'reason', 'file', 'request']);
        $validator = Validator::make ($input, [
            'user_id' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'request' => 'required|numeric'
        ] ,Helper::messageValidation());
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
        $shiftEmployee = ShiftEmployee::join('shifts', 'shift_employees.shift_id', '=', 'shifts.id')
        ->where('employee_id', $employee->id)
        ->whereDate('date', $now)
        ->first();
        if ($distcance > 1) {
            $message = 'Jarak untuk Checkin tidak boleh Lebih dari 1 Km dari kantor';
            if ($input['request'] == 2) {
                $message = 'Jarak untuk Checkout tidak boleh Lebih dari 1 Km dari kantor';
            }
            return $this->resp(['distance' => $distcance, 'nearest office' => $nearestOffice],
            $message, false, 406);
        }
        if ($input['request'] == 1) {
            if ($checkCheckin) {
                return $this->resp(null, 'Anda Sudah Checkin Hari Ini', false, 406);
            }
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checkin Hari Ini', false, 406);
            }
            $status = 0;
            $schedule_in = Carbon::parse($shiftEmployee->schedule_in)->addMinute(15);
            if ($now > $schedule_in && $now <= $schedule_in) {
                $status = 1;
            }
            elseif ($now > $schedule_in && $now > $schedule_in) {
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
            $inputScheckin = [
                'checkin_id' => $checkin->id,
                'reason' => $input['reason'],
                'file' => $request->file,
                'type' => 1
            ];
            return $this->storeData(new SpecialCheckin, [
                'checkin_id' => 'required|numeric',
                'type' => 'required|numeric',
                'reason' => 'required|min:5|max:255',
                'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072',
            ], $inputScheckin, [
                'type' => Variable::SPCK,
                'field' => 'file'
            ]);
        } elseif ($input['request'] == 2){
            if ($checkCheckout) {
                return $this->resp(null, 'Anda Sudah Checkout Hari Ini', false, 406);
            }
            if (!$checkCheckin) {
                return $this->resp(null, 'Anda Belum Checkin Hari Ini', false, 406);
            }
            if (!$shiftEmployee) {
                return $this->resp(null, 'Anda Tidak Memiliki Shcedule Checout Hari Ini', false, 406);
            }
            $checkCheckin->update(['checkout_time' => Carbon::now()]);
            $inputScheckin = [
                'checkin_id' => $checkCheckin->id,
                'reason' => $input['reason'],
                'file' => $request->file,
                'type' => 2
            ];
            return $this->storeData(new SpecialCheckin, [
                'checkin_id' => 'required|numeric',
                'type' => 'required|numeric',
                'reason' => 'required|min:5|max:255',
                'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072',
            ], $inputScheckin, [
                'type' => Variable::SPCK,
                'field' => 'file'
            ]);
        }

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
