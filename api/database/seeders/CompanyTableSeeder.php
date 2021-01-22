<?php

namespace Database\Seeders;

use App\Models\Companies;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Companies::create([
            'name' => 'Test Company',
            'address' => 'Test Company Address',
            'lat' => -6.200000,
            'lng' => 106.816666,
        ]);
    }
}
