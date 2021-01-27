<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\ShiftImport;
use App\Exports\ShiftExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    public function getCompanyShift(Request $request)
    {
        return $this->getPaginate(Shift::query()->where('company_id', $request->company_id), $request,['shift_name', 'code'],
        $request,[
            'shift_name'
        ]);
    }

    public function addShift(Request $request)
    {
        $input = $request->only('company_id', 'shift_name', 'code', 'schedule_in', 'schedule_out');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'shift_name' => 'required',
            'code' => 'required',
            'schedule_in' => 'required',
            'schedule_out' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Shift', false, 401);
        }
        $addShift = Shift::create($input);
        return $this->resp($addShift);
    }

    public function updateShift(Request $request, $id)
    {
        $shift = Shift::find($id);
        if(!$shift)
        {
            return $this->resp(null, 'Shift Tidak Ditemukan', false, 406);
        }
        $input = $request->only('company_id', 'shift_name', 'code', 'schedule_in', 'schedule_out');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'shift_name' => 'required',
            'code' => 'required',
            'schedule_in' => 'required',
            'schedule_out' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Edit Shift', false, 401);
        }
        $editShift = $shift->update($input);
        return $this->resp($editShift);
    }

    public function deleteShift($id)
    {
        $shift = Shift::find($id);
        if(!$shift)
        {
            return $this->resp(null, 'Shift Tidak Ditemukan', false, 406);
        }
        $shift->delete();
        return $this->resp();
    }

    public function importShift(Request $request)
    {
        $validator = Validator::make($request->only(['file']), [
            'file' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Import Excel', false, 401);
        }
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import(new ShiftImport, $file);
            return $this->resp($import);
        }
    }

    public function exportShift(Request $request)
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
        return Excel::download(new ShiftExport($request->company_id), 'shifts.' . $type, $as);
    }
}
