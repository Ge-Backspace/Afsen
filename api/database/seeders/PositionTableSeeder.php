<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create([
            'company_id' => 1,
            'name' => 'Position Test',
            'group' => 'Test'
        ]);
    }
}
