<?php

namespace Database\Seeders;

use App\Models\StatusPermission;
use Illuminate\Database\Seeder;

class StatusPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusPermission::create([
            'company_id' => 1,
            'status_name' => 'Menunggu Perizinan',
            'code' => 'MP'
        ]);

        StatusPermission::create([
            'company_id' => 1,
            'status_name' => 'Diizinkan',
            'code' => 'DI'
        ]);

        StatusPermission::create([
            'company_id' => 1,
            'status_name' => 'Ditolak',
            'code' => 'DT'
        ]);
    }
}
