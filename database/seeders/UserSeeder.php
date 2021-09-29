<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@cricsmash.com',
            'password' => bcrypt('Cricsmash!@#$'),
            'remember_token' => null,
            'created_at'=> Carbon::now('Asia/Kolkata')->toDateTimeString()
        ]);
        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@cricsmash.com',
            'password' => bcrypt('Cricsmash!@#$'),
            'remember_token' => null,
            'created_at'=> Carbon::now('Asia/Kolkata')->toDateTimeString()
        ]);
        DB::table('users')->insert([
            'role_id' => 3,
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@cricsmash.com',
            'password' => bcrypt('Cricsmash!@#$'),
            'remember_token' => null,
            'created_at'=> Carbon::now('Asia/Kolkata')->toDateTimeString()
        ]);
    }
}
