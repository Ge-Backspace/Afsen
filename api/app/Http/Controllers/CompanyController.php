<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function getCompany(Request $request)
    {
        return $this->getPaginate(Companies::where('id', $request->company_id), $request,['id']);
    }

    public function getAllCompanies(Request $request)
    {
        return $this->getPaginate(Companies::query()->orderBy('id', 'DESC'), $request, ['name']);
    }

    public function updateCompany(Request $request, $id)
    {
        $input = $request->only(['name']);
        $rules = [
            'name' => 'required|string',
        ];
        $validator = Validator::make ($input, $rules ,Helper::messageValidation());
        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()
            ->getMessages()), false, 406);
        }
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
