<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Employee;
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
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $e = Employee::leftJoin(
            'checkins as c', function($join) use($startDate,$endDate) {
                $join->on('employees.id', '=', 'c.employee_id')
                ->whereDate('c.checkout_time', '>=', $startDate)
                ->whereDate('c.checkout_time', '<=', $endDate);
            }
        )
        ->join('positions as p', 'employees.position_id', '=', 'p.id')
        ->get();
        return $this->resp($e);
    }

}
