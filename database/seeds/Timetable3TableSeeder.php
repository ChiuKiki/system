<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timetable3TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timetable3')->insert([
            ['name'=>'测试一','number'=>201830250000,'department'=>'技术部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'测试二','number'=>201862880000,'department'=>'技术部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'测试三','number'=>201854680000,'department'=>'视频部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'测试四','number'=>201830660000,'department'=>'技术部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],
            ['name'=>'测试五','number'=>201830770000,'department'=>'视频部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ],['name'=>'测试六','number'=>201830880000,'department'=>'视频部',
                'Tuesday12'=>'1','Tuesday34'=>'1'
            ]
        ]);
    }
}
