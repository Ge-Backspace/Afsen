<?php

namespace App\Http\Controllers;

use App\Helpers\Variable;
use App\Models\Companies;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompany(Request $request)
    {
        return $this->getPaginate(Companies::where('id', $request->company_id), $request);
    }

    public function getAllCompanies(Request $request)
    {
        return $this->getPaginate(Companies::query()->orderBy('id', 'DESC'), $request, ['name']);
    }

    public function updateCompany(Request $request, $id)
    {
        $input = $request->only(['name']);
        $table = Companies::find($id);
        return $this->updateData($table, [
            'name' => 'required|string',
            'foto' => 'mimes:jpeg,png,jpg|max:2048'
        ], $input, [
            'type' => Variable::COMP,
            'field' => 'foto'
        ]);
    }

    public function deleteCompany($id){
        $table = Companies::find($id);
        return $this->deleteData($table);
    }
}
