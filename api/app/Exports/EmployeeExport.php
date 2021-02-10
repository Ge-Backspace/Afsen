<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{

    // protected $company_id;
    // protected $name;
    // protected $nip;
    // protected $kontak;
    // protected $status;
    // protected $position;




    // function __construct($company_id, $name, $nip, $kontak, $status, $position)
    // {
    //     ini_set('memory_limit', '-1');
    //     ini_set('max_execution_time', 0);
    //     $this->company_id = $company_id;
    //     $this->name = $name;
    //     $this->nip = $nip;
    //     $this->kontak = $kontak;
    //     $this->status = $status;
    //     $this->position = $position;
    // }

    public function view(): View
    {
        $carbon = new Carbon();
        return view('attendanceReport', [
            // 'name' => $this->tax_returns->get(),
            // 'name' => $this->name,
            // 'nip' => $this->nip,
            // 'kontak' => $this->kontak,
            // 'status' => $this->status,
            // 'position' => $this->position,
            // 'carbon' => $carbon,
        ]);
    }
}
