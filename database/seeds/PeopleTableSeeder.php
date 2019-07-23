<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('people')->insert([
            ['name'=>'a','gender'=>'女','grade'=>'2018级','number'=>201830250000,'tel'=>15800000000,'email'=>'123456@qq.com','school'=>'电信','department'=>'技术部','position'=>'干事','password'=>'abc123',],
            ['name'=>'b','gender'=>'男','grade'=>'2017级','number'=>201862880000,'tel'=>13600000000,'email'=>'666666@qq.com','school'=>'计算机','department'=>'技术部','position'=>'部长','password'=>'abc000',],
            ['name'=>'c','gender'=>'男','grade'=>'2016级','number'=>201854680000,'tel'=>17800000000,'email'=>'222222@qq.com','school'=>'电信','department'=>'视频部','position'=>'干事','password'=>'aaaaaa',],
            ['name'=>'d','gender'=>'女','grade'=>'2017级','number'=>201830250000,'tel'=>13200000000,'email'=>'aaaaaaa@qq.com','school'=>'计算机','department'=>'技术部','position'=>'干事','password'=>'1111111',],
            ['name'=>'e','gender'=>'女','grade'=>'2017级','number'=>201830250000,'tel'=>19900000000,'email'=>'duhuhdcyua@qq.com','school'=>'电信','department'=>'视频部','position'=>'部长','password'=>'222222',],
            ['name'=>'f','gender'=>'男','grade'=>'2018级','number'=>201830250000,'tel'=>13400000000,'email'=>'1dfaefa6@qq.com','school'=>'计算机','department'=>'视频部','position'=>'干事','password'=>'3333333',]
        ]);
    }
}
