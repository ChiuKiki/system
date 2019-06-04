<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class People extends Model
{

    public static function checkAccount($user,$password){
        //法一：
        //$result=DB::select('select * from administrator where name=? and password=?',[$user,$password]);
        //法二：
        $result=DB::table('administrator')->where(['name'=>$user,'password'=>$password])->first();

        return $result;
    }


    public static function querySchool($queryName){
        $result=DB::table('people')->where(['school'=>$queryName])->get();
        return $result;
    }

    public static function queryDepartment($queryName){
        $result=DB::table('people')->where(['department'=>$queryName])->get();
        return $result;
    }


    public static function updatePeople($name,$gender,$grade,$number,$tel,$email,$school,$department,$position){
        $row=DB::table('people')->where(['name'=>$name])->first();
        $rowId=isset($row->id)?($row->id):'';     //修改名字所在行的id
        $result = DB::table('people')->where('id', $rowId)->update(
            ['name'=>$name,'gender'=>$gender,'grade'=>$grade,'number'=>$number,'tel'=>$tel,
                'email'=>$email,'school'=>$school,'department'=>$department,'position'=>$position]
        );
        return $result;
    }


    public static function insertPeople($name,$gender,$grade,$number,$tel,$email,$school,$department,$position){
        $result=DB::table('people')->insert(
            ['name'=>$name,'gender'=>$gender,'grade'=>$grade,'number'=>$number,'tel'=>$tel,
                'email'=>$email,'school'=>$school,'department'=>$department,'position'=>$position]
        );
        return $result;
    }


    public static function insertAdministrator($name,$password){
        $result=DB::table('administrator')->insert(
            ['name'=>$name,'password'=>$password]
        );
        return $result;
    }
}
