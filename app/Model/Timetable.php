<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Timetable extends Model
{
    public $timestamps = false;

    //确定没课时间
    public static function checkTime($request){
        $day = $request->get('day');
        $class = $request->get('class');
        $result = 0;

        switch($day){

            case "1":
                switch($class){
                    case "1-2":$result="Monday12";break;
                    case "3-4":$result="Monday34";break;
                    case "noon":$result="MondayNoon";break;
                    case "5-6":$result="Monday56";break;
                    case "7-8":$result="Monday78";break;
                }
                break;

            case "2":
                switch($class){
                    case "1-2":$result="Tuesday12";break;
                    case "3-4":$result="Tuesday34";break;
                    case "noon":$result="TuesdayNoon";break;
                    case "5-6":$result="Tuesday56";break;
                    case "7-8":$result="Tuesday78";break;
                }
                break;

            case "3":
                switch($class){
                    case "1-2":$result="Wednesday12";break;
                    case "3-4":$result="Wednesday34";break;
                    case "noon":$result="WednesdayNoon";break;
                    case "5-6":$result="Wednesday56";break;
                    case "7-8":$result="Wednesday78";break;
                }
                break;

            case "4":
                switch($class){
                    case "1-2":$result="Thursday12";break;
                    case "3-4":$result="Thursday34";break;
                    case "noon":$result="ThursdayNoon";break;
                    case "5-6":$result="Thursday56";break;
                    case "7-8":$result="Thursday78";break;
                }
                break;

            case "5":
                switch($class){
                    case "1-2":$result="Friday12";break;
                    case "3-4":$result="Friday34";break;
                    case "noon":$result="FridayNoon";break;
                    case "5-6":$result="Friday56";break;
                    case "7-8":$result="Friday78";break;
                }
                break;

            default:
                return $result=0;
        }
        return $result;
    }


    //根据周数选择数据表
    public static function checkTable($weekNum){
        switch($weekNum){
            case "1":
                $table = 'timetable1';break;
            case "2":
                $table = 'timetable2';break;
            case "3":
                $table = 'timetable3';break;
            case "4":
                $table = 'timetable4';break;
            case "5":
                $table = 'timetable5';break;
            case "6":
                $table = 'timetable6';break;
            case "7":
                $table = 'timetable7';break;
            case "8":
                $table = 'timetable8';break;
            case "9":
                $table = 'timetable9';break;
            case "10":
                $table = 'timetable10';break;
            case "11":
                $table = 'timetable11';break;
            case "12":
                $table = 'timetable12';break;
            case "13":
                $table = 'timetable13';break;
            case "14":
                $table = 'timetable14';break;
            case "15":
                $table = 'timetable15';break;
            case "16":
                $table = 'timetable16';break;
            case "17":
                $table = 'timetable17';break;
            case "18":
                $table = 'timetable18';break;
            default:
                return $table = NULL;
        }
        return $table;
    }


    //查询没课人员
    public static function freeTime($time,$request){
        $weekNum = $request->get('weekNum');
        $department = $request->get('department');

        //根据周数选择数据表
        $table = self::checkTable($weekNum);

        //判断是否选择“部门”
        //查询没课人员
        //默认（有课）为null，没课为1
        if($department) {
            $matchInfo = DB::table($table)
                ->where($time, 1)
                ->where('department', $department)
                ->get('name');
        }else{
            $matchInfo = DB::table($table)
                ->where($time, 1)
                ->get('name');
        }

        //前端需要形如{name:["1","2","3"]}的结果
        $arr = array();
        foreach ($matchInfo as $nameList){
            array_push($arr,$nameList->name);
        }
        $result = array('name'=>$arr);
        return $result;

    }


    //确定没课时间数组（arr[课号][星期几]）
    public static function checkTimeArr($request){
        $arr = $request->get('arr');
        $tempArr = array();

        for($i = 0; $i < 5; $i++){
            for ($j = 0; $j < 5; $j++) {
                //没课为1，有课为0
                if($arr[$j][$i]) {
                    //class格式变换 0 => 1-2
                    switch ($j){
                        case "0":
                            $class = "1-2";break;
                        case "1":
                            $class = "3-4";break;
                        case "2":
                            $class = "noon";break;
                        case "3":
                            $class = "5-6";break;
                        case "4":
                            $class = "7-8";break;
                        default:
                            $class = "0";
                    }
                    //修改request参数
                    $request->merge(['day' => $i+1, 'class' => $class]);
                    $time = self::checkTime($request);
                    //写入数组
                    array_push($tempArr, $time);
                }
            }
        }
        return $tempArr;
    }


    //根据周数确定数据表数组
    public static function checkTableArr($request){
        $weekNum = $request->get('weekNum');
        $tempArr = array();
        $len = sizeof($weekNum);

        for($i = 0; $i < $len ; $i++){
            //根据周数选择数据表
            $table = self::checkTable($weekNum[$i]);
            //写入数组
            array_push($tempArr, $table);
        }
        return $tempArr;
    }


    //没课表录入
    public static function insertFreeTime($time,$table){
        $timeLen = sizeof($time);
        $tableLen = sizeof($table);
        $result = 0;
        //先清空已有的信息
        $reset = self::resetFreeTime($table);

        for($i = 0; $i < $tableLen ; $i++) {
            for ($j = 0; $j < $timeLen; $j++) {
                $result = DB::table($table[$i])
                    ->where('number', Session::get('number'))
                    ->update([$time[$j] => '1']);
            }
        }
        return $result;
    }


    //重置某用户没课表的内容
    public static function resetFreeTime($table){
        $len = sizeof($table);
        $result = 0;

        for($i = 0; $i < $len ; $i++) {
            $result = DB::table($table[$i])
                ->where('number', Session::get('number'))
                ->update(['Monday12' => NULL, 'Monday34' => NULL, 'MondayNoon' => NULL, 'Monday56' => NULL, 'Monday78' => NULL,
                    'Tuesday12' => NULL, 'Tuesday34' => NULL, 'TuesdayNoon' => NULL, 'Tuesday56' => NULL, 'Tuesday78' => NULL,
                    'Wednesday12' => NULL, 'Wednesday34' => NULL, 'WednesdayNoon' => NULL, 'Wednesday56' => NULL, 'Wednesday78' => NULL,
                    'Thursday12' => NULL, 'Thursday34' => NULL, 'ThursdayNoon' => NULL, 'Thursday56' => NULL, 'Thursday78' => NULL,
                    'Friday12' => NULL, 'Friday34' => NULL, 'FridayNoon' => NULL, 'Friday56' => NULL, 'Friday78' => NULL,
                ]);
        }
        return $result;
    }
}
