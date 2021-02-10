<?php

namespace Database\Seeders;

use App\Models\ShiftEmployee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TodayShiftEmployee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShiftEmployee::create([
            'company_id' => 1,
            'employee_id' => 2,
            'shift_id' => 1,
            'date' => Carbon::today()
        ]);
    }
}
