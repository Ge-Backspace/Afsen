<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\StatusPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\StatusPermissionImport;
use App\Exports\StatusPermissionExport;
use Maatwebsite\Excel\Facades\Excel;

class StatusPermissionController extends Controller
{
    public function getCompanyStatusPermission(Request $request)
    {
        return $this->getPaginate(StatusPermission::where('company_id', $request->company_id), $request, ['status_name', 'code']);
    }

    public function addStatusPermission(Request $request)
    {
        $input = $request->only('company_id', 'status_name', 'code');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'status_name' => 'required|string',
            'code' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Status Permission', false, 401);
        }
        $addStatusPermission = StatusPermission::create($input);
        return $this->resp($addStatusPermission);
    }

    public function updateStatusPermission(Request $request, $id)
    {
        $statusPermission = StatusPermission::find($id);
        if(!$statusPermission)
        {
            return $this->resp(null, 'Status Permission Tidak Ditemukan', false, 406);
        }
        $input = $request->only('company_id', 'status_name', 'code');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'status_name' => 'required',
            'code' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Edit Status Permission', false, 401);
        }
        $editStatusPermission = $statusPermission->update($input);
        return $this->resp($editStatusPermission);
    }

    public function deleteStatusPermission($id)
    {
        $statusPermission = StatusPermission::find($id);
        if(!$statusPermission)
        {
            return $this->resp(null, 'Status Permission Tidak Ditemukan', false, 406);
        }
        $statusPermission->delete();
        return $this->resp();
    }

    public function importStatusPermission(Request $request)
    {
        $validator = Validator::make($request->only(['company_id', 'file']), [
            'company_id' => 'required',
            'file' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Import Excel', false, 401);
        }
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import(new StatusPermissionImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportStatusPermission(Request $request)
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
        return Excel::download(new StatusPermissionExport($request->company_id), 'status_permissions.' . $type, $as);
    }
}
