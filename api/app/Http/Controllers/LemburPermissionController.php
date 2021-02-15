<?php

namespace App\Http\Controllers;

use App\Helpers\Variable;
use App\Models\LemburPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LemburPermissionController extends Controller
{
    public function getLemburPermission(Request $request)
    {
        $table = LemburPermission::join('employees as e', 'lembur_permissions.employee_id', '=', 'e.id')
        ->join('users as u', 'e.user_id', '=', 'u.id')
        ->where('u.company_id', $request->company_id)
        ->select(DB::raw('lembur_permissions.*, e.name'));
        return $this->getPaginate($table, $request, ['e.name', 'lembur_permissions.date']);
    }

    public function addLemburPermission(Request $request)
    {
        $input = $request->only('employee_id', 'schedule_in', 'schedule_out', 'date', 'reason', 'file');
        return $this->storeData(new LemburPermission, [
            'employee_id' => 'required|numeric',
            'schedule_in' => 'required',
            'date' => 'required|date',
            'reason' => 'required|min:5|max|255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::LEPE,
            'field' => 'file'
        ]);
    }

    public function updateLemburPermission(Request $request, $id)
    {
        $model = LemburPermission::find($id);
        $input = $request->only('employee_id', 'schedule_in', 'schedule_out', 'date', 'reason', 'file');
        return $this->updateData($model, [
            'employee_id' => 'required|numeric',
            'schedule_in' => 'required',
            'date' => 'required|date',
            'reason' => 'required|min:5|max|255',
            'file' => 'mimes:jpeg,png,jpg,pdf,doc,docx|max:3072'
        ], $input, [
            'type' => Variable::LEPE,
            'field' => 'file'
        ]);
    }

    public function delete($id)
    {
        return $this->deleteData(LemburPermission::find($id));
    }

    public function changeStatusPermission(Request $request, $id)
    {
        $table = LemburPermission::find($id);
        if (!$table) {
            return $this->resp(null, 'Permission Lembur Tidak Ditemukan', false, 406);
        } elseif ($table->status_id != 0) {
            return $this->resp(null, 'Status Permission Lembur Sudah Diubah', false, 406);
        }
        $s['status_id'] = 2;
        if ($request->status == 1) {
            $s['status_id'] = 1;
        }
        $update = $table->update($s);
        return $this->resp($update);
    }
}
