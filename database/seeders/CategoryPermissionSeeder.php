<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder for Category Permissions
        DB::table('permissions')->insert([
            'name' => 'Category.Read',
            'display_name' => 'Category Read',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Category.Write',
            'display_name' => 'Category Write',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Category.Update',
            'display_name' => 'Category Update',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Category.Delete',
            'display_name' => 'Category Delete',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'Category.Export',
            'display_name' => 'Category Export',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
    }
}
