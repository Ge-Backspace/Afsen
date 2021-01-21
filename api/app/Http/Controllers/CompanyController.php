<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function getCompany(Request $request)
    {
        $company = Companies::find($request->company_id);
        return $this->resp($company->first());
    }

    public function getAllCompanies(Request $request)
    {
        return $this->getPaginate(Companies::query()->orderBy('id', 'DESC'), $request, ['name']);
    }

    public function updateCompany(Request $request, $id)
    {
        if (!$id) {
            $id = $request->company_id;
        }
        $input = $request->only(['name']);
        $company = $company = Companies::find($id);
        if (!$company) {
            return $this->resp(null, 'Company Tidak Ditemukan');
        }
        $updateCompany = $company->update($input);
        return $this->resp($updateCompany);
    }

    public function deleteCompany($id){
        $company = $company = Companies::find($id);
        if (!$company) {
            return $this->resp(null, 'Company Tidak Ditemukan');
        }
        $company->delete();
        return $this->resp();
    }
}
