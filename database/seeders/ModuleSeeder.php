<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'name' => 'Category',
            'created_by' => 1,
            'created_at'=> Carbon::now('Asia/Kolkata')
        ]);
        DB::table('modules')->insert([
            'name' => 'News',
            'created_by' => 1,
            'created_at'=> Carbon::now('Asia/Kolkata')
        ]);
        DB::table('modules')->insert([
            'name' => 'Reference',
            'created_by' => 1,
            'created_at'=> Carbon::now('Asia/Kolkata')
        ]);
    }
}
