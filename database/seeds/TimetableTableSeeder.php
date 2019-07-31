<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimetableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timetables')->insert([
            ['name'=>'a','number'=>201830250000,
                'Monday12'=>'1','Friday34'=>'1'
            ],
            ['name'=>'b','number'=>201862880000,
                'Monday12'=>'1','Friday34'=>'1'
            ],
            ['name'=>'c','number'=>201854680000,
                'Monday12'=>'1','Friday34'=>'1'
            ]
        ]);
    }
}
