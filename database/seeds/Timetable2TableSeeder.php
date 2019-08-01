<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timetable2TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timetable2')->insert([
            ['name'=>'a','number'=>201830250000,'department'=>'技术部',
                'Wednesday12'=>'1','Wednesday34'=>'1'
            ],
            ['name'=>'b','number'=>201862880000,'department'=>'技术部',
                'Wednesday12'=>'1','Wednesday34'=>'1'
            ],
            ['name'=>'c','number'=>201854680000,'department'=>'视频部',
                'Wednesday12'=>'1','Wednesday34'=>'1'
            ]
        ]);
    }
}
