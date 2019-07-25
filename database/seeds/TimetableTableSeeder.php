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
            ['name'=>'a','number'=>201830253333,
                'Monday1'=>'有','Monday2'=>'有','Monday3'=>'有','Monday4'=>'有','Monday5'=>'无','Monday6'=>'有','Monday7'=>'有','Monday8'=>'有','Monday9'=>'有',
                'Tuesday1'=>'有','Tuesday2'=>'有','Tuesday3'=>'有','Tuesday4'=>'有','Tuesday5'=>'有','Tuesday6'=>'有','Tuesday7'=>'有','Tuesday8'=>'有','Tuesday9'=>'有',
                'Wednesday1'=>'有','Wednesday2'=>'有','Wednesday3'=>'有','Wednesday4'=>'有','Wednesday5'=>'有','Wednesday6'=>'有','Wednesday7'=>'有','Wednesday8'=>'有','Wednesday9'=>'无',
                'Thursday1'=>'有', 'Thursday2'=>'有', 'Thursday3'=>'有', 'Thursday4'=>'有', 'Thursday5'=>'有', 'Thursday6'=>'有', 'Thursday7'=>'有', 'Thursday8'=>'有', 'Thursday9'=>'有',
                'Friday1'=>'有','Friday2'=>'有','Friday3'=>'有','Friday4'=>'有','Friday5'=>'有','Friday6'=>'有','Friday7'=>'有','Friday8'=>'有','Friday9'=>'有'
                ],
            ['name'=>'b','number'=>201830250000,
                'Monday1'=>'有','Monday2'=>'有','Monday3'=>'有','Monday4'=>'有','Monday5'=>'无','Monday6'=>'有','Monday7'=>'有','Monday8'=>'有','Monday9'=>'有',
                'Tuesday1'=>'有','Tuesday2'=>'有','Tuesday3'=>'有','Tuesday4'=>'有','Tuesday5'=>'有','Tuesday6'=>'有','Tuesday7'=>'有','Tuesday8'=>'有','Tuesday9'=>'有',
                'Wednesday1'=>'有','Wednesday2'=>'有','Wednesday3'=>'有','Wednesday4'=>'有','Wednesday5'=>'有','Wednesday6'=>'有','Wednesday7'=>'有','Wednesday8'=>'有','Wednesday9'=>'有',
                'Thursday1'=>'有', 'Thursday2'=>'有', 'Thursday3'=>'有', 'Thursday4'=>'有', 'Thursday5'=>'有', 'Thursday6'=>'有', 'Thursday7'=>'有', 'Thursday8'=>'有', 'Thursday9'=>'有',
                'Friday1'=>'有','Friday2'=>'有','Friday3'=>'有','Friday4'=>'有','Friday5'=>'有','Friday6'=>'有','Friday7'=>'有','Friday8'=>'有','Friday9'=>'有'
            ],
            ['name'=>'c','number'=>201830250001,
                'Monday1'=>'有','Monday2'=>'有','Monday3'=>'有','Monday4'=>'有','Monday5'=>'无','Monday6'=>'有','Monday7'=>'有','Monday8'=>'有','Monday9'=>'有',
                'Tuesday1'=>'有','Tuesday2'=>'有','Tuesday3'=>'有','Tuesday4'=>'有','Tuesday5'=>'有','Tuesday6'=>'有','Tuesday7'=>'有','Tuesday8'=>'有','Tuesday9'=>'有',
                'Wednesday1'=>'有','Wednesday2'=>'有','Wednesday3'=>'有','Wednesday4'=>'有','Wednesday5'=>'有','Wednesday6'=>'有','Wednesday7'=>'有','Wednesday8'=>'有','Wednesday9'=>'无',
                'Thursday1'=>'有', 'Thursday2'=>'有', 'Thursday3'=>'有', 'Thursday4'=>'有', 'Thursday5'=>'有', 'Thursday6'=>'有', 'Thursday7'=>'有', 'Thursday8'=>'有', 'Thursday9'=>'有',
                'Friday1'=>'有','Friday2'=>'有','Friday3'=>'有','Friday4'=>'有','Friday5'=>'有','Friday6'=>'有','Friday7'=>'有','Friday8'=>'有','Friday9'=>'有'
            ]
        ]);
    }
}
