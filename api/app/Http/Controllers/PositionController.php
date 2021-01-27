<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\PositionImport;
use App\Exports\PositionExport;
use Maatwebsite\Excel\Facades\Excel;

class PositionController extends Controller
{
    public function getPosition(Request $request)
    {
        $position = Position::where('company_id', $request->company_id);
        return $this->getPaginate($position,$request,[
            'position_name'
        ]);
        return $this->resp($position);
    }

    public function optionPosition(Request $request)
    {
        $position = Position::where('company_id', $request->company_id)->get();
        return $this->resp($position);
    }

    public function addPosition(Request $request)
    {
        $input = $request->only('company_id', 'position_name', 'group');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_name' => 'required|string',
            'group' => 'required|string'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Position', false, 401);
        }
        $addPosition = Position::create($input);
        return $this->resp($addPosition);
    }

    public function updatePosition(Request $request, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return $this->resp(null, 'Position tidak ditemukan', false, 406);
        }
        $input = $request->only(['company_id', 'position_name', 'group']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_name' => 'required|string',
            'group' => 'required|string'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp([$input, Helper::generateErrorMsg($validator->errors()->getMessages())], 'Failed Edit Position', false, 406);
        }
        $update = [
            'position_name' => $input['position_name'],
            'group' => $input['group']
        ];
        $editPosition = $position->update($update);
        return $this->resp($editPosition);
    }

    public function deletePosition($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return $this->resp(null, 'Position tidak ditemukan', false, 406);
        }
        $position->delete();
        return $this->resp();
    }

    public function importPosition(Request $request)
    {
        $validator = Validator::make($request->only(['file']), [
            'company_id' => 'required',
            'file' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Import Excel', false, 401);
        }
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import(new PositionImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportPosition(Request $request)
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
        return Excel::download(new PositionExport($request->company_id), 'positions.' . $type, $as);
    }
}
