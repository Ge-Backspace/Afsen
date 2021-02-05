<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GajiEmployeeController extends Controller
{
    public function getGajiEmployee(Request $request)
    {
        return $this->getPaginate(
            Employee::join('positions as p', 'employees.position_id', '=', 'p.id')
            ->join('gajis as g', 'p.id', '=', 'g.position_id')
            ->select(DB::raw('employees.name, *'))
            ,$request, []
        );
    }
}
