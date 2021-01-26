<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPosition(Request $request)
    {
        $position = Position::where('company_id', $request->company_id);
        return $this->getPaginate($position,$request,[
            'position_name'
        ]);
        return $this->resp($position);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPosition(Request $request)
    {
        $input = $request->only('company_id', 'position_name', 'group');
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_name' => 'required|string',
            'group' => 'required|string'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp(Helper::generateErrorMsg($validator->errors()->getMessages()), 'Failed Add Position', false, 401);
        }
        $addPosition = Position::create($input);
        return $this->resp($addPosition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(Request $request, $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return $this->resp(null, 'Position tidak ditemukan', false, 406);
        }
        $input = $request->only(['company_id', 'position_name', 'group']);
        $validator = Validator::make($input, [
            'company_id' => 'required|numeric',
            'position_name' => 'required|string',
            'group' => 'required|string'
        ], Helper::messageValidation());
        if ($validator->fails()) {
            return $this->resp([$input, Helper::generateErrorMsg($validator->errors()->getMessages())], 'Failed Edit Position', false, 406);
        }
        $update = [
            'position_name' => $input['position_name'],
            'group' => $input['group']
        ];
        $editPosition = $position->update($update);
        return $this->resp($editPosition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletePosition($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return $this->resp(null, 'Position tidak ditemukan', false, 406);
        }
        $position->delete();
        return $this->resp();
    }
}
