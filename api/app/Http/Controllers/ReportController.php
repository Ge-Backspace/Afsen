<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Checkin;
use App\Models\CutiPermission;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function reportAttendance(Request $request)
    {

        $input = $request->only(['company_id' ,'startDate', 'endDate']);
        $rules = [
            'company_id' => 'required|numeric',
            'startDate' => 'required|date|date_format:Y-m-d',
            'endDate' => 'required|date|date_format:Y-m-d'
        ];
        $validator = Validator::make ($input, $rules ,Helper::messageValidation());
        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()
            ->getMessages()), false, 406);
        }
        $company_id = $input['company_id'];
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $start_date = Carbon::parse($startDate);
        $end_date = Carbon::parse($endDate);
        $e = Employee::whereHas('users', function($q) use($company_id){
            $q->where('company_id', $company_id);
        })
        ->get();
        $dates = [];
        while ($start_date <= $end_date) {
            $dates[] =  $start_date->format('Y-m-d');
            $start_date->addDay(1);
        }

        $result = [];
        foreach ($e as $value) {
            $checkins = [];
            foreach($dates as $date) {
                $checkin = Checkin::where('employee_id', $value->id)
                                ->whereDate('checkin_time', $date)
                                ->first();
                $cuti = $this->checkCuti($value->id, $date);
                $checkins[] = [
                    'date' => $date . ' - ' . date('l', strtotime($date)),
                    'checkin_time' => $checkin ? $checkin->checkin_time->format('H:i:s') : null,
                    'checkout_time' => $checkin ? $checkin->checkout_time->format('H:i:s') : null,
                    'status_checkin' => $checkin ? $checkin->status : null,
                    'is_cuti' => $cuti ? $cuti->cuti_name : null,
                    'is_weekend' => Carbon::parse($date)->dayOfWeek == Carbon::SUNDAY || Carbon::parse($date)->dayOfWeek == Carbon::SATURDAY ? true : false
                ];
                $start_date->addDay(1);
            }
            $data =  $value->toArray();
            $data['checkins'] = $checkins;
            $result[] = $data;
        }
        return $this->resp(['data' => $result, 'dates' => $dates, 'start_date' => $dates[0]]);
    }

    public function checkCuti($id, $date)
    {
        $cuti = CutiPermission::join('cutis', 'cuti_permissions.cuti_id', '=', 'cutis.id')
        ->where('employee_id', $id)
        ->where('status_id', 1)
        ->get();
        if (!$cuti) {
            return null;
        }
        $result = null;
        foreach ($cuti as $value) {
            $sd = Carbon::parse($value->star_date);
            $ed = Carbon::parse($value->expired_date)->addDay(1);
            $dates = [];
            while ($sd <= $ed) {
                $dates[] = $sd->format('Y-m-d');
                $sd->addDay(1);
            }
            $status = false;
            foreach ($dates as $val) {
                if ($val == $date) {
                    $status = $value;
                }
            }
            $result = $status;
        }
        return $result;
    }
}
