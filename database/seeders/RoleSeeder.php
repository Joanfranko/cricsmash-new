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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
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
        DB::table('roles')->insert([
            'name' => 'View Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'name' => 'Create Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'name' => 'Edit Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'name' => 'Delete Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        /* Permissions */
        DB::table('permissions')->insert([
            'name' => 'View Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Create Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Edit Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Delete Category',
            'guard_name' => 'web',            
            'created_at'=>date('Y-m-d H:i:s')
        ]);

        /* Role has Permissions */
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 2
        ]);

        /* Model has Roles */
        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\Models\User',            
            'model_id'=> '1'
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '4',
            'model_type' => 'App\Models\User',            
            'model_id'=> '1'
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\Models\User',            
            'model_id'=> '2'
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '4',
            'model_type' => 'App\Models\User',            
            'model_id'=> '2'
        ]);

        /* Role has permissions */
        DB::table('model_has_permissions')->insert([
            'permission_id' => 1,
            'model_type' => 'App\Models\User',            
            'model_id'=> 1,
        ]);
        DB::table('model_has_permissions')->insert([
            'permission_id' => 2,
            'model_type' => 'App\Models\User',            
            'model_id'=> 1,
        ]);
        DB::table('model_has_permissions')->insert([
            'permission_id' => 3,
            'model_type' => 'App\Models\User',            
            'model_id'=> 1,
        ]);
        DB::table('model_has_permissions')->insert([
            'permission_id' => 1,
            'model_type' => 'App\Models\User',            
            'model_id'=> 2,
        ]);
    }
}
