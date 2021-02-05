<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Gaji;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Imports\GajiImport;
use App\Exports\GajiExport;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{
    public function getCompanyGaji(Request $request)
    {
        return $this->getPaginate(Gaji::join('positions as p', 'gajis.position_id', '=', 'p.id')
        ->where('p.company_id', $request->company_id)
        ->select(DB::raw('gajis.*, p.*, gajis.id as id'))
        ->orderBy('gajis.id', 'DESC')
        ,$request,[
            'p.position_name', 'p.group'
        ]);
    }

    public function addGaji(Request $request)
    {
        $input = $request->only(['company_id' ,'position_id', 'gaji']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'gaji' => 'required|numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Gaji', false, 401);
        }
        $position = Position::find($input['position_id']);
        $gaji = Gaji::where('position_id', $input['position_id'])->first();
        if (!$position) {
            return $this->resp(null, 'Position Tidak Ditemukan', false, 406);
        } elseif($position->company_id != $request->company_id){
            return $this->resp(null, 'Data Position Tidak Ditemukan', false, 406);
        } elseif ($gaji) {
            return $this->resp(null, 'Data Gaji Sudah Ada Di Position Tersebut', false, 406);
        }
        $add = Gaji::create([
            'position_id' => $input['position_id'],
            'gaji' => $input['gaji']
        ]);
        return $this->resp($add);
    }

    public function updateGaji(Request $request, $id)
    {
        $input = $request->only(['company_id' ,'position_id', 'gaji']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'gaji' => 'required|numeric',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Gaji', false, 401);
        }
        $position = Position::find($input['position_id']);
        $table = Gaji::find($id);
        if (!$position) {
            return $this->resp(null, 'Data Position Tidak Ditemukan', false, 406);
        } elseif($position->company_id != $request->company_id){
            return $this->resp(null, 'Data Position Tidak Ditemukan', false, 406);
        } elseif (!$table) {
            return $this->resp(null, 'Data Gaji Tidak Ditemukan', false, 406);
        }
        $update = $table->update([
            'position_id' => $input['position_id'],
            'gaji' => $input['gaji']
        ]);
        return $this->resp($update);
    }

    public function deleteGaji($id)
    {
        $gaji = Gaji::find($id);
        if (!$gaji) {
            return $this->resp(null, 'Data Gaji Tidak Ditemukan', false, 406);
        }
        $delete = $gaji->delete();
        return $this->resp($delete);
    }

    public function importGaji(Request $request)
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
            $import = Excel::import(new GajiImport($request->company_id), $file);
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
        return Excel::download(new GajiExport($request->company_id), 'gaji.' . $type, $as);
    }
}
