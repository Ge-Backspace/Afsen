<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Imports\ProductsExport;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{

    public function masukData(Request $request){
        $foo = new ProductsImport();
        $this->validate($request, [
            'file' => 'required'
        ]);
        if($request->hasFile('file')){
            $file = $request->file('file');
            $import = Excel::import($foo, $file);
            return $this->resp($import);
        }
        return redirect()->back()-with(['error' => 'please choose file before']);
    }

    public function keluarData(Request $request){

        $as = \Maatwebsite\Excel\Excel::XLSX;
        $type = 'xlsx';
        if($request->as == 'pdf'){
            $type = 'pdf';
            $as = \Maatwebsite\Excel\Excel::DOMPDF;
        }
        return Excel::download(new ProductsExport, 'products.' . $type, $as);
        // return (new ProductsExport)->download('invoices.pdf', $as);
    }

    public function cetak_pdf()
    {
        $product = Product::all();
    	$pdf = PDF::loadView('invoice', ['products'=>$product]);
        return $pdf->download('invoice.pdf');
    }
}
