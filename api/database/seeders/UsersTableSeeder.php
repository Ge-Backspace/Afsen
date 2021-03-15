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
            'role_id' => 1,
            'username' => 'Test Super Admin',
            'email' => 'testsuperadmin@gmail.com',
            'password' => app('hash')->make('testadmin'),
            'aktif' => true,
        ]);

        DB::table('users')->insert([
            'company_id' => 1,
            'role_id' => 2,
            'username' => 'Test Admin',
            'email' => 'testadmin@gmail.com',
            'password' => app('hash')->make('testadmin'),
            'aktif' => true,
        ]);

        DB::table('users')->insert([
            'company_id' => 1,
            'role_id' => 3,
            'username' => 'Test User',
            'email' => 'testuser@gmail.com',
            'password' => app('hash')->make('testuser'),
            'aktif' => true,
        ]);
    }
}
