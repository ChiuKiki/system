<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

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
                    case "12":$result="Monday12";break;
                    case "34":$result="Monday34";break;
                    case "noon":$result="MondayNoon";break;
                    case "56":$result="Monday56";break;
                    case "78":$result="Monday78";break;
                }
                break;

            case "2":
                switch($class){
                    case "12":$result="Tuesday12";break;
                    case "34":$result="Tuesday34";break;
                    case "noon":$result="TuesdayNoon";break;
                    case "56":$result="Tuesday56";break;
                    case "78":$result="Tuesday78";break;
                }
                break;

            case "3":
                switch($class){
                    case "12":$result="Wednesday12";break;
                    case "34":$result="Wednesday34";break;
                    case "noon":$result="WednesdayNoon";break;
                    case "56":$result="Wednesday56";break;
                    case "78":$result="Wednesday78";break;
                }
                break;

            case "4":
                switch($class){
                    case "12":$result="Thursday12";break;
                    case "34":$result="Thursday34";break;
                    case "noon":$result="ThursdayNoon";break;
                    case "56":$result="Thursday56";break;
                    case "78":$result="Thursday78";break;
                }
                break;

            case "5":
                switch($class){
                    case "12":$result="Friday12";break;
                    case "34":$result="Friday34";break;
                    case "noon":$result="FridayNoon";break;
                    case "56":$result="Friday56";break;
                    case "78":$result="Friday78";break;
                }
                break;

            default:
                return $result=0;
        }
        return $result;
    }


    //查询没课人员
    public static function freeTime($time){
        //默认为null，没课为1
        $matchInfo = Timetable::where($time, 1)->get('name');
        //前端需要形如{name:["1","2","3"]}的结果
        $arr = array();
        foreach ($matchInfo as $nameList){
            array_push($arr,$nameList->name);
        }
        $result=array('name'=>$arr);
        return $result;
    }


}
