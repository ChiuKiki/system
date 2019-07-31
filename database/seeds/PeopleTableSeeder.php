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
            ['name'=>'a','birthday'=>'10.17','QQ'=>840084384,'number'=>201830250000,'tel'=>15800000000,'email'=>'123456@qq.com','school'=>'电信','department'=>'技术部','position'=>'干事','password'=>'abc123',],
            ['name'=>'b','birthday'=>'9.21','QQ'=>25629891,'number'=>201862880000,'tel'=>13600000000,'email'=>'666666@qq.com','school'=>'计算机','department'=>'技术部','position'=>'部长','password'=>'abc000',],
            ['name'=>'c','birthday'=>'8.27','QQ'=>268992918,'number'=>201854680000,'tel'=>17800000000,'email'=>'222222@qq.com','school'=>'电信','department'=>'视频部','position'=>'干事','password'=>'aaaaaa',],
            ['name'=>'d','birthday'=>'9.4','QQ'=>9588892220,'number'=>201830660000,'tel'=>13200000000,'email'=>'aaaaaaa@qq.com','school'=>'计算机','department'=>'技术部','position'=>'干事','password'=>'1111111',],
            ['name'=>'e','birthday'=>'1.1','QQ'=>1115166,'number'=>201830770000,'tel'=>19900000000,'email'=>'duhuhdcyua@qq.com','school'=>'电信','department'=>'视频部','position'=>'副部长','password'=>'222222',],
            ['name'=>'f','birthday'=>'6.14','QQ'=>589582001,'number'=>201830880000,'tel'=>13400000000,'email'=>'1dfaefa6@qq.com','school'=>'计算机','department'=>'视频部','position'=>'干事','password'=>'3333333',]
        ]);
    }
}
