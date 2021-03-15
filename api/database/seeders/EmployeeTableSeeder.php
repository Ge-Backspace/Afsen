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
            'user_id' => 1,
            'name' => 'Test Super Admin',
            'position_id' => 1,
            'status' => true
        ]);

        Employee::create([
            'user_id' => 2,
            'name' => 'Test Admin',
            'position_id' => 1,
            'status' => true
        ]);

        Employee::create([
            'user_id' => 3,
            'name' => 'Test User',
            'position_id' => 1,
            'status' => true
        ]);
    }
}
