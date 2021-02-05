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
        $company_id = $input['company_id'];
        $startDate = $input['startDate'];
        $endDate = $input['endDate'];
        $e = Employee::with([
            'positions',
            'checkins' => function($query) use($startDate, $endDate){
                $query->whereDate('checkout_time', '>=', $startDate)
                ->whereDate('checkout_time', '<=', $endDate);
            }
        ])
        ->whereHas('users', function($q) use($company_id){
            $q->where('company_id', $company_id);
        })
        ->get();
        return $this->resp($e);
    }

}
