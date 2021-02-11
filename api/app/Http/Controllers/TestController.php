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
        $input = $request->only(['name', 'foto']);
        return $this->storeData(new Test,[
            'name' => 'required|string|min:4|max:100',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], $input,[
            'type' => Variable::TEST,
            'field' => 'foto'
        ]);
    }
}
