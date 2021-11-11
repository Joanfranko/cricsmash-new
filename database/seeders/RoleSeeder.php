<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('model_has_roles')->truncate();
        /*DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');*/
        
        /* Roles */
        DB::table('roles')->insert([
            'name' => 'SuperAdmin',
            'display_name' => 'Super Admin',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('roles')->insert([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('roles')->insert([
            'name' => 'User',
            'display_name' => 'User',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);

        /* Permissions */
        /*DB::table('permissions')->insert([
            'name' => 'Read',
            'display_name' => 'Read',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Write',
            'display_name' => 'Write',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Update',
            'display_name' => 'Update',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Delete',
            'display_name' => 'Delete',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Export',
            'display_name' => 'Export',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);*/

        /* Role has Permissions */
        /*DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 2
        ]);*/

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
