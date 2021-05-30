<?php

namespace App\Http\Controllers;

use App\Model\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PeopleController extends Controller
{
    //测试登陆——登录
    //http://system.chiukiki.cn/api/operatorLogin?number=201862880000&password=abc000
    public function loginModel(Request $request)
    {
        $result = People::checkAccount($request);
        //0:未登录     1:已登录
        switch($result){

            case "notExist":
                Session::put('flag',0);
                return response(array(['message'=>'账号不存在']),401);
                break;
            case "ok":
                Session::put('flag',1);
                return response(array(['message'=>'登陆成功']));
                break;
            default:
                Session::put('flag',0);
                return response(array('message' => '用户名或密码错误'), 401);

        }
    }


    //测试注册——注册
    //http://system.chiukiki.cn/api/insert?name=测试&number=201830255555&tel=15800000000&department=技术部&password=abc123&confirmPassword=abc123
    public function insertModel(Request $request)
    {
        $password = $request->get('password');
        $confirmPassword = $request->get('confirmPassword');
        $number = $request->get('number');
        $isNumberExist = People::isNumberExist($number);

        //检查数据库中是否有该学号
        if(!$isNumberExist) {
            //检查密码是否一致
            if($password == $confirmPassword) {
                $result = People::insertPeople($request);
                if ($result) {
                    return response(array('message' => '注册成功'));
                } else {
                    return response(array('message' => '注册失败'), 403);
                }
            }else{
                return response(array('message' => '密码不一致'), 403);
            }
        }else{
            return response(array('message' => '该学号已被注册'), 403);
        }
    }


    //测试忘记密码
    //http://system.chiukiki.cn/api/forgetPassword?number=201830660000&tel=13200000000&setPassword=111111
    public static function forgetPasswordModel(Request $request)
    {
        $result = People::findPassword($request);
        switch ($result){
            case "-2" :
                return response(array('message'=>'学号不存在'),403);
                break;
            case "-1" :
                return response(array('message'=>'手机号与学号不匹配'),403);
                break;
            case "0" :
                return response(array('message'=>'找回密码失败'),403);
                break;
            case "1" :
                return response(array('message'=>'找回密码成功'));
                break;
            default :
                return response(array('message'=>'找回密码失败'),403);
        }
    }


    //测试注销
    //http://system.chiukiki.cn/api/operatorLogout
    public function logoutModel(Request $request)
    {
        Session::flush();
        return response(array('message'=>'注销成功'));

    }


    //测试获取自己信息
    //http://system.chiukiki.cn/api/queryNumber?queryNumber=201830250000
    public function queryNumberModel(Request $request){
        $number = $request->get('queryNumber');

        //只能获取自己信息
        if (Session::get('number') != $number) {
            return response(array('message' => '无权限'), 403);
        } else {
            $result = People::allInfoNumber($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
    }


    //测试修改信息
    //http://system.chiukiki.cn/api/updatePeople?name=测试&birthday=10.17&QQ=1169849916&number=201830990000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&message=test
    public function updatePeopleModel(Request $request){
        $number = $request->get('number');

        switch (Session::get('flag')){
            //未登录
            case "0":
                return response(array('message'=>'无权限'),403);
                break;
            //已登录
            case "1":
                //只能改自己的信息
                if(Session::get('number') != $number){
                    return response(array('message'=>'无权限'),403);
                }else{
                    $result = People::updatePeople($request);
                }
                break;
            default :
                $result = 0;
        }

        if ($result) {
            return response(array('message'=>'修改成功'));
        } else {
            return response(array('message'=>'修改失败'),403);
        }

    }

}