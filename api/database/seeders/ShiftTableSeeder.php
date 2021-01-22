<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shift::create([
            'company_id' => 1,
            'name' => 'Weekday',
            'code' => 'WD',
            'schedule_in' => '08:00:00',
            'schedule_out' => '16:00:00'
        ]);

        Shift::create([
            'company_id' => 1,
            'name' => 'Day Off',
            'code' => 'DO',
            'schedule_in' => '00:00:00',
            'schedule_out' => '00:00:00'
        ]);
    }
}
