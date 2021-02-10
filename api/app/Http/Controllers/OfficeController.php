<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function getCompanyOffice(Request $request)
    {
        $table = Office::where('company_id', $request->company_id)
        ->orderBy('id', 'DESC');
        return $this->getPaginate($table, $request, ['office_name', 'lat', 'lng', 'address']);
    }

    public function getCoorditaneOffice(Request $request)
    {
        $office = Office::where('company_id', $request->company_id);
        $markers = [];
        foreach ($office->get() as $of) {
            $markers[] = ['position' => ['lat' => $of->lat, 'lng' => $of->lng]];
        }
        $center = $this->getCenter($office->get(['lat', 'lng']));
        return $this->resp(['data' => $markers, 'center' => ['lat' => $center[0], 'lng' => $center[1]]]);
    }

    public function addOffice(Request $request)
    {
        $input = $request->only(['company_id', 'office_name' ,'lat', 'lng', 'address']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'office_name' => 'required|string',
            'lat' => 'required',
            'lng' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Office', false, 401);
        }
        $address = $this->getAddress($input['lat'], $input['lng']);
        $input = Arr::set($input, 'address', $address['formatted_address']);
        $add = Office::create($input);
        return $this->resp($add);
    }

    public function updateOffice(Request $request, $id)
    {
        $office = Office::find($id);
        if (!$office) {
            return $this->resp(null, 'Office Tidak Ditemukan', false, 406);
        }
        $input = $request->only(['company_id' ,'lat', 'lng', 'address']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'lat' => 'required',
            'lng' => 'required',
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Update Office', false, 401);
        }
        $address = $this->getAddress($input['lat'], $input['lng']);
        $input = Arr::set($input, 'address', $address['formatted_address']);
        $update = $office->update($input);
        $input = Arr::add($input, 'update', $update);
        return $this->resp($input);
    }

    public function deleteOffice($id)
    {
        $office = Office::find($id);
        if (!$office) {
            return $this->resp(null, 'Office Tidak Ditemukan', false, 406);
        }
        $delete = $office->delete();
        return $this->resp(['delete' => $delete]);
    }
}
