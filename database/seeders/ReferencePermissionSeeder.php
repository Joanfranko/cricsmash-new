<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReferencePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeder for Reference Permissions
        DB::table('permissions')->insert([
            'name' => 'Reference.Read',
            'display_name' => 'Reference Read',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Reference.Write',
            'display_name' => 'Reference Write',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Reference.Update',
            'display_name' => 'Reference Update',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Reference.Delete',
            'display_name' => 'Reference Delete',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Reference.Export',
            'display_name' => 'Reference Export',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
    }
}
