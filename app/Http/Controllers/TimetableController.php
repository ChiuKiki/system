<?php

namespace App\Http\Controllers;

use App\Model\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimetableController extends Controller
{
    //测试没课查询
    //127.0.0.1/frame/system/public/api/free?day=1&class=12
    public static function noClassModel(Request $request)
    {
        $time = Timetable::checkTime($request);

        if (Session::get('flag')) {

            $result = Timetable::freeTime($time);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查询失败'), 403);
            }

        } else {
            return response(array('message' => '无权限'), 403);
        }
    }
}
