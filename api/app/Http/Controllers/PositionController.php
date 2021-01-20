<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

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
            'name'
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
        $input = $request->only('company_id','name');
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
    public function update(Request $request, $id)
    {
        $input = $request->only('company_id', 'name');
        $position = Position::find($id);
        $editPosition = $position->update($input);
        return $this->resp($editPosition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Position::find($id)->delete();
        return $this->resp();
    }
}
