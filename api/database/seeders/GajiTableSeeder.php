<?php

namespace Database\Seeders;

use App\Models\Gaji;
use Illuminate\Database\Seeder;

class GajiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Gaji::create([
            'position_id' => 1,
            'gaji' => 5000000
        ]);
    }
}
