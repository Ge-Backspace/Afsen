<?php

namespace Database\Seeders;

use App\Models\Cuti;
use Illuminate\Database\Seeder;

class CutiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cuti::create([
            'company_id' => 1,
            'cuti_name' => 'Cuti Tahunan',
            'code' => 'CT'
        ]);
    }
}
