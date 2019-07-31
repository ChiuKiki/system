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
                    case "1":$result="Monday1";break;
                    case "2":$result="Monday2";break;
                    case "3":$result="Monday3";break;
                    case "4":$result="Monday4";break;
                    case "5":$result="Monday5";break;
                    case "6":$result="Monday6";break;
                    case "7":$result="Monday7";break;
                    case "8":$result="Monday8";break;
                    case "9":$result="Monday9";break;
                }
                break;

            case "2":
                switch($class){
                    case "1":$result="Tuesday1";break;
                    case "2":$result="Tuesday2";break;
                    case "3":$result="Tuesday3";break;
                    case "4":$result="Tuesday4";break;
                    case "5":$result="Tuesday5";break;
                    case "6":$result="Tuesday6";break;
                    case "7":$result="Tuesday7";break;
                    case "8":$result="Tuesday8";break;
                    case "9":$result="Tuesday9";break;
                }
                break;

            case "3":
                switch($class){
                    case "1":$result="Wednesday1";break;
                    case "2":$result="Wednesday2";break;
                    case "3":$result="Wednesday3";break;
                    case "4":$result="Wednesday4";break;
                    case "5":$result="Wednesday5";break;
                    case "6":$result="Wednesday6";break;
                    case "7":$result="Wednesday7";break;
                    case "8":$result="Wednesday8";break;
                    case "9":$result="Wednesday9";break;
                }
                break;

            case "4":
                switch($class){
                    case "1":$result="Thursday1";break;
                    case "2":$result="Thursday2";break;
                    case "3":$result="Thursday3";break;
                    case "4":$result="Thursday4";break;
                    case "5":$result="Thursday5";break;
                    case "6":$result="Thursday6";break;
                    case "7":$result="Thursday7";break;
                    case "8":$result="Thursday8";break;
                    case "9":$result="Thursday9";break;
                }
                break;

            case "5":
                switch($class){
                    case "1":$result="Friday1";break;
                    case "2":$result="Friday2";break;
                    case "3":$result="Friday3";break;
                    case "4":$result="Friday4";break;
                    case "5":$result="Friday5";break;
                    case "6":$result="Friday6";break;
                    case "7":$result="Friday7";break;
                    case "8":$result="Friday8";break;
                    case "9":$result="Friday9";break;
                }
                break;

            default:
                return $result=0;
        }
        return $result;
    }


    //查询没课人员
    public static function freeTime($time){
        //默认为0，没课为1
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
