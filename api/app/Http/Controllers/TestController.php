<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Excel;

class TestController extends Controller
{

    public function masukData(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);

        if($request->hasFile('file')){
            $file = $request->file('file');
            Excel::import(new ProductsImport, $file);
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()-with(['error' => 'please choose file before']);
    }
}
