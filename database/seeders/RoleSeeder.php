<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Roles */
        DB::table('roles')->insert([
            'name' => 'Super Admin',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
            'name' => 'User',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        /* Model has Roles */
        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\Models\User',            
            'model_id'=> '1'
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\Models\User',            
            'model_id'=> '2'
        ]);
    }
}
