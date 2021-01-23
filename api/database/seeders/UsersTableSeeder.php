<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'company_id' => 1,
            'username' => 'test',
            'email' => 'test@gmail.com',
            'password' => app('hash')->make('testuser')
        ]);
    }
}
