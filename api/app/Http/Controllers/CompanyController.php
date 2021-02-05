<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function getCompany(Request $request)
    {
        return $this->getPaginate(Companies::where('id', $request->company_id), $request,['id']);
    }

    public function getCoorditaneCompany(Request $request)
    {
        $coordinate = Companies::find($request->company_id);
        return $this->resp(['lat' => $coordinate->lat, 'lng' => $coordinate->lng]);
    }

    public function getAllCompanies(Request $request)
    {
        return $this->getPaginate(Companies::query()->orderBy('id', 'DESC'), $request, ['name']);
    }

    public function updateCompany(Request $request, $id)
    {
        $input = $request->only(['name' ,'address', 'lat', 'lng']);
        $rules = [
            'name' => 'required|string',
            'lat' => 'required',
            'lng' => 'required'
        ];
        $validator = Validator::make ($input, $rules ,Helper::messageValidation());
        if($validator->fails()){
            return $this->resp($request->all(), Helper::generateErrorMsg($validator->errors()
            ->getMessages()), false, 406);
        }
        $address = $this->getAddress($input['lat'], $input['lng']);
        Arr::set($input, 'address', $address['formatted_address']);
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
