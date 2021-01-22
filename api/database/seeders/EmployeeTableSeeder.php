<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'company_id' => 1,
            'user_id' => 1,
            'name' => 'test',
            'position_id' => 1,
            'status' => true
        ]);
    }
}
