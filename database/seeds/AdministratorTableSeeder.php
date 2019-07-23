<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdministratorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('administrator')->insert([
            ['name'=>'root','password'=>12345]
        ]);
    }
}
