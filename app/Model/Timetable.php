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


    //确定没课时间数组（arr[][]）
    public static function checkTimeArr($request){
        $arr = $request->get('arr');
        /*
        $arr[0][0] = 0;
        $arr[0][1] = 0;
        $arr[0][2] = 0;
        $arr[0][3] = 0;
        $arr[0][4] = 0;

        $arr[1][0] = 0;
        $arr[1][1] = 0;
        $arr[1][2] = 0;
        $arr[1][3] = 0;
        $arr[1][4] = 0;

        $arr[2][0] = 0;
        $arr[2][1] = 0;
        $arr[2][2] = 0;
        $arr[2][3] = 0;
        $arr[2][4] = 0;

        $arr[3][0] = 0;
        $arr[3][1] = 0;
        $arr[3][2] = 0;
        $arr[3][3] = 0;
        $arr[3][4] = 0;

        $arr[4][0] = 0;
        $arr[4][1] = 0;
        $arr[4][2] = 0;
        $arr[4][3] = 0;
        $arr[4][4] = 1;
        */

        $tempArr = array();

        for($i = 0; $i < 5; $i++){
            for ($j = 0; $j < 5; $j++) {
                //没课为1，有课为0
                if($arr[$i][$j]) {
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
                    //写入result数组
                    array_push($tempArr, $time);
                }
            }
        }
        return $tempArr;
    }

/*
    //确定没课时间数组（day[],class[]）
    //http://127.0.0.1/frame/system/public/api/insertFree?weekNum=0&day[]=5&class[]=1-2&day[]=4&class[]=3-4
    public static function checkTimeArr($request){
        $day = $request->get('day');
        $class = $request->get('class');
        $dayLen = sizeof($day);
        $classLen = sizeof($class);
        $arr = array();

        if($dayLen == $classLen) {

            for ($i = 0; $i < $dayLen; $i++) {
                //修改request参数
                $request->merge(['day'=>$day[$i],'class'=>$class[$i]]);
                $time = self::checkTime($request);
                //写入result数组
                array_push($arr,$time);
            }
            $result = $arr;

        }else{
            return $result = 0;
        }

        return $result;
    }
*/

    //查询没课人员
    public static function freeTime($time,$request){

        $weekNum = $request->get('weekNum');
        $department = $request->get('department');

        //选择单双周：单周为-1，双周为0
        switch($weekNum){
            //默认为null，没课为1
            case "-1":
                if($department) {
                    $matchInfo = DB::table('timetableOdd')
                        ->where($time, 1)
                        ->where('department', $department)
                        ->get('name');
                }else{
                    $matchInfo = DB::table('timetableOdd')
                        ->where($time, 1)
                        ->get('name');
                }
                break;
            case "0":
                if($department) {
                    $matchInfo = DB::table('timetableEven')
                        ->where($time, 1)
                        ->where('department', $department)
                        ->get('name');
                }else{
                    $matchInfo = DB::table('timetableEven')
                        ->where($time, 1)
                        ->get('name');
                }
                break;
            default:
                return $matchInfo = 0;
        }

        //前端需要形如{name:["1","2","3"]}的结果
        $arr = array();
        foreach ($matchInfo as $nameList){
            array_push($arr,$nameList->name);
        }
        $result = array('name'=>$arr);
        return $result;

    }


    //没课表录入
    public static function insertFreeTime($time,$request){
        $weekNum = $request->get('weekNum');
        //选择单双周：单周为-1，双周为0，单双周为-2
        switch($weekNum){
            //默认为null，没课为1
            case"-2":
                $len = sizeof($time);
                $resultOdd = 0;
                $resultEven = 0;
                //先清空已有的信息
                $resetOdd = self::resetFreeTime('timetableOdd');
                $resetEven = self::resetFreeTime('timetableEven');

                for($i = 0; $i < $len ; $i++){
                    $resultOdd = DB::table('timetableOdd')
                        ->where('number', Session::get('number'))
                        ->update([$time[$i] => '1']);
                    $resultEven = DB::table('timetableEven')
                        ->where('number', Session::get('number'))
                        ->update([$time[$i] => '1']);
                }
                return $resetOdd&$resetEven&$resultOdd&$resultEven;
                break;

            case "-1":
                $len = sizeof($time);
                $result = 0;
                //先清空已有的信息
                $resetOdd = self::resetFreeTime('timetableOdd');
                for($i = 0; $i < $len ; $i++){
                    $result = DB::table('timetableOdd')
                        ->where('number', Session::get('number'))
                        ->update([$time[$i] => '1']);
                }
                return $resetOdd&$result;
                break;

            case "0":
                $len = sizeof($time);
                $result = 0;
                //先清空已有的信息
                $resetEven = self::resetFreeTime('timetableEven');
                for($i = 0; $i < $len ; $i++){
                    $result = DB::table('timetableEven')
                        ->where('number', Session::get('number'))
                        ->update([$time[$i] => '1']);
                }
                return $resetEven&$result;
                break;

            default:
                return $result = 0;
        }
    }


    //重置某用户没课表的内容
    public static function resetFreeTime($table){
        $result = DB::table($table)
            ->where('number', Session::get('number'))
            ->update(['Monday12' => NULL,'Monday34' => NULL,'MondayNoon' => NULL,'Monday56' => NULL,'Monday78' => NULL,
                'Tuesday12' => NULL,'Tuesday34' => NULL,'TuesdayNoon' => NULL,'Tuesday56' => NULL,'Tuesday78' => NULL,
                'Wednesday12' => NULL,'Wednesday34' => NULL,'WednesdayNoon' => NULL,'Wednesday56' => NULL,'Wednesday78' => NULL,
                'Thursday12' => NULL,'Thursday34' => NULL,'ThursdayNoon' => NULL,'Thursday56' => NULL,'Thursday78' => NULL,
                'Friday12' => NULL,'Friday34' => NULL,'FridayNoon' => NULL,'Friday56' => NULL,'Friday78' => NULL,
            ]);
        return $result;
    }


}
