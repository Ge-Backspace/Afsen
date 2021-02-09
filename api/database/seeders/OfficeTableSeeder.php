<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Office::create([
            'office_name' => 'Test Office 1',
            'company_id' => 1,
            'address' => 'Test Company Address',
            'lat' => -6.200000,
            'lng' => 106.816666,
        ]);
    }
}
