<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Variable;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Imports\ProductsExport;
use App\Models\Checkin;
use App\Models\Files\File;
use App\Models\Office;
use App\Models\Product;
use App\Models\ShiftEmployee;
use App\Models\Test;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Crap4j;

class TestController extends Controller
{

    // public function masukData(Request $request){
    //     $foo = new ProductsImport();
    //     $this->validate($request, [
    //         'file' => 'required'
    //     ]);
    //     if($request->hasFile('file')){
    //         $file = $request->file('file');
    //         $import = Excel::import($foo, $file);
    //         return $this->resp($import);
    //     }
    //     return redirect()->back()-with(['error' => 'please choose file before']);
    // }

    // public function keluarData(Request $request){

    //     $as = \Maatwebsite\Excel\Excel::XLSX;
    //     $type = 'xlsx';
    //     if($request->as == 'pdf'){
    //         $type = 'pdf';
    //         $as = \Maatwebsite\Excel\Excel::DOMPDF;
    //     }
    //     return Excel::download(new ProductsExport, 'products.' . $type, $as);
    //     // return (new ProductsExport)->download('invoices.pdf', $as);
    // }

    // public function cetak_pdf()
    // {
    //     $product = Product::all();
    // 	$pdf = PDF::loadView('invoice', ['products'=>$product]);
    //     return $pdf->download('invoice.pdf');
    // }

    public function test(Request $request)
    {
        $input = $request->only(['company_id', 'employee_id', 'shift_id', 'start_date', 'end_date']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'employee_id' => 'required|numeric',
            'shift_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Shift Employee', false, 401);
        }
        $st = Carbon::parse($input['start_date']);
        $ed = Carbon::parse($input['end_date']);
        $add = [];
        for ($st; $st <= $ed; $st->addDay(1)) {
            $shiftEmployee = ShiftEmployee::where('employee_id', $input['employee_id'])
            ->whereDate('date', $st->format('Y-m-d'))->first();
            if ($shiftEmployee) {
                return $this->resp(null, 'Jadwal Shift Employee Sudah Ada Pada Tanggal Tersebut', false, 406);
            }
            $add[] = [
                'company_id' => $input['company_id'],
                'employee_id' => $input['employee_id'],
                'shift_id' => $input['shift_id'],
                'date' => $st->format('Y-m-d')
            ];
        }
        $addSE = ShiftEmployee::insert($add);
        return $this->resp($addSE);
    }
}
