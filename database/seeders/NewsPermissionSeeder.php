<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NewsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeder for News Permissions
        DB::table('permissions')->insert([
            'name' => 'News.Read',
            'display_name' => 'News Read',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'News.Write',
            'display_name' => 'News Write',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'News.Update',
            'display_name' => 'News Update',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'News.Delete',
            'display_name' => 'News Delete',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
        DB::table('permissions')->insert([
            'name' => 'News.Export',
            'display_name' => 'News Export',
            'guard_name' => 'web',
            'created_at'=>Carbon::now('Asia/Kolkata')
        ]);
    }
}
