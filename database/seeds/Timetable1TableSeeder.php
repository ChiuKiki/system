<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timetable1TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timetable1')->insert([
            ['name'=>'a','number'=>201830250000,'department'=>'技术部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'b','number'=>201862880000,'department'=>'技术部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'c','number'=>201854680000,'department'=>'视频部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ]
        ]);
    }
}
