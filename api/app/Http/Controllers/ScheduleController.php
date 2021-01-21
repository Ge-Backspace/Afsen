<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSchedule(Request $request)
    {
        $scheduleToday = Schedule::where('company_id', $request->company_id)
        ->where('hari', $request->today)
        ->first();

        return $this->resp($scheduleToday);
    }

    public function addSchedule(Request $request)
    {
        $input = $request->only('company_id', 'hari', 'urut', 'schedule_in', 'schedule_out');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'hari' => 'required',
            'urut' => 'required|numeric',
            'schedule_in' => 'required',
            'schedule_out' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Schedule', false, 401);
        }
        $addSchedule = Schedule::create($input);
        return $this->resp($addSchedule);
    }

    public function editSchedule(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if(!$schedule)
        {
            return $this->resp(null, 'Schedule tidak ditemukan', false, 406);
        }
        $input = $request->only('company_id', 'hari', 'urut', 'schedule_in', 'schedule_out');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'hari' => 'required',
            'urut' => 'required|numeric',
            'schedule_in' => 'required',
            'schedule_out' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Edit Schedule', false, 401);
        }
        $editSchedule = $schedule->update($input);
        return $this->resp($editSchedule);
    }

    public function deleteSchedule($id)
    {
        $schedule = Schedule::find($id);
        if(!$schedule)
        {
            return $this->resp(null, 'Schedule tidak ditemukan', false, 406);
        }
        $schedule->delete();
        return $this->resp();
    }
}
