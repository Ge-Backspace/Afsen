<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Imports\CutiImport;
use App\Exports\CutiExport;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
    public function getCompanyCuti(Request $request)
    {
        return $this->getPaginate(Cuti::where('company_id', $request->company_id), $request, ['cuti_name', 'code']);
    }

    public function addCuti(Request $request)
    {
        $input = $request->only('company_id', 'cuti_name', 'code');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'cuti_name' => 'required|string',
            'code' => 'required'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Cuti', false, 401);
        }
        $addCuti = Cuti::create($input);
        return $this->resp($addCuti);
    }

    public function updateCuti(Request $request, $id)
    {
        $cuti = Cuti::find($id);
        if(!$cuti)
        {
            return $this->resp(null, 'Cuti Tidak Ditemukan', false, 406);
        }
        $input = $request->only('company_id', 'cuti_name', 'code');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'cuti_name' => 'required',
            'code' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Edit Cuti', false, 401);
        }
        $editCuti = $cuti->update($input);
        return $this->resp($editCuti);
    }

    public function deleteCuti($id)
    {
        $cuti = Cuti::find($id);
        if(!$cuti)
        {
            return $this->resp(null, 'Cuti Tidak Ditemukan', false, 406);
        }
        $cuti->delete();
        return $this->resp();
    }

    public function importCuti(Request $request)
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
            $import = Excel::import(new CutiImport($request->company_id), $file);
            return $this->resp($import);
        }
    }

    public function exportCuti(Request $request)
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
        return Excel::download(new CutiExport($request->company_id), 'cutis.' . $type, $as);
    }
}
