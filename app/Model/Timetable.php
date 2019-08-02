<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Timetable extends Model
{
    public $timestamps = false;

    //确定查询没课时间
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


    //查询没课人员
    public static function freeTime($time,$request){

        $weekNum = $request->get('weekNum');
        $department = $request->get('department');

        //选择单双周：单周为-1，双周为0
        switch($weekNum){
            //默认为null，没课为1
            case "-1":
                if($department) {
                    $matchInfo = DB::table('timetableOdd')->where($time, 1)->where('department', $department)->get('name');
                }else{
                    $matchInfo = DB::table('timetableOdd')->where($time, 1)->get('name');
                }
                break;
            case "0":
                if($department) {
                    $matchInfo = DB::table('timetableEven')->where($time, 1)->where('department', $department)->get('name');
                }else{
                    $matchInfo = DB::table('timetableEven')->where($time, 1)->get('name');
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
        $result=array('name'=>$arr);
        return $result;

    }



    //没课表录入
    public static function insertFreeTime($time,$request){

        $weekNum = $request->get('weekNum');
        //选择单双周：单周为-1，双周为0
        switch($weekNum){
            //默认为null，没课为1
            case "-1":
                $result = DB::table('timetableOdd')->where('number', Session::get('number'))->update([$time => '1']);
                break;
            case "0":
                $result = DB::table('timetableEven')->where('number', Session::get('number'))->update([$time => '1']);
                break;
            default:
                return $result = 0;
        }

        return $result;

    }

}
