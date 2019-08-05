<?php

namespace App\Http\Controllers;

use App\Model\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimetableController extends Controller
{
    //测试没课查询
    //http://127.0.0.1/frame/system/public/api/free?weekNum=0&day=3&class=1-2&department=技术部
    public static function noClassModel(Request $request)
    {
        $time = Timetable::checkTime($request);

        if (Session::get('flag')) {

            $result = Timetable::freeTime($time,$request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查询失败'), 403);
            }

        } else {
            return response(array('message' => '无权限'), 403);
        }
    }


    //测试没课录入
    //weekNum=0/-1/-2&arr[][]
    public static function insertNoClassModel(Request $request)
    {
        //确定没课时间数组
        $time = Timetable::checkTimeArr($request);

        if (Session::get('flag')) {

            $result = Timetable::insertFreeTime($time,$request);
            if ($result) {
                return response(array('message' => '录入成功'));
            } else {
                return response(array('message' => '录入失败'), 403);
            }

        } else {
            return response(array('message' => '无权限'), 403);
        }


    }


}
