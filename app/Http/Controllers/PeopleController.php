<?php

namespace App\Http\Controllers;

use App\Model\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PeopleController extends Controller
{
    //测试登陆——登录
    //127.0.0.1/frame/system/public/api/operatorLogin?number=201862880000&password=abc000
    public function loginModel(Request $request)
    {
        $result = People::checkAccount($request);
        //0:未登录     1:已登录且为管理员   2:已登录
        switch($result){

            case "administrator":
                Session::put('flag',1);
                return response(array(['message'=>'登陆成功','identity'=>'administrator']));
                break;

            case "people":
                Session::put('flag',2);
                return response(array(['message'=>'登陆成功','identity'=>'people']));
                break;

            default:
                Session::put('flag',0);
                return response(array('message' => '用户名或密码错误'), 401);

        }
    }


    //测试添加——注册
    //127.0.0.1/frame/system/public/api/insert?name=测试&number=201830250000&tel=15800000000&department=技术部&password=abc123&confirmPassword=abc123
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
    //127.0.0.1/frame/system/public/api/forgetPassword?number=201830250000&tel=13400000000&setPassword=123456
    public static function forgetPasswordModel(Request $request)
    {
        $result = People::findPassword($request);
        if ($result) {
            return response(array('message'=>'找回密码成功'));
        } else {
            return response(array('message'=>'找回密码失败'),403);
        }
    }


    //测试注销
    //127.0.0.1/frame/system/public/api/operatorLogout
    public function logoutModel(Request $request)
    {
        Session::flush();
        return response(array('message'=>'注销成功'));

    }


    //测试首页——百步梯通讯录
    //127.0.0.1/frame/system/public/api/queryInitial
    public function queryInitialModel(Request $request){
        //要登陆
        if (Session::get('flag') != 2) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::queryInitial($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '无法显示'), 403);
            }
        }
    }


    //测试搜索框查询——百步梯通讯录
    //127.0.0.1/frame/system/public/api/queryInfo?query=技术部
    public function queryInfoModel(Request $request){
        //要登陆
        if (Session::get('flag') != 2) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::queryInfo($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
    }


    //测试搜索框查询——百步梯通讯录（修改状态）
    //127.0.0.1/frame/system/public/api/queryInfoAdmin?query=技术部
    public function queryInfoAdminModel(Request $request){
        //要管理员权限
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::queryInfoAdmin($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
    }


    //测试批量删除——百步梯通讯录（修改状态）
    //127.0.0.1/frame/system/public/api/delete?number[]=201830259999&number[]=201830258888&number[]=201830257777
    public static function deleteModel(Request $request)
    {
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::deletePeople($request);
            if ($result) {
                return response(array('message'=>'删除成功'));
            } else {
                return response(array('message'=>'删除失败'),403);
            }
        }
    }


    //测试修改——百步梯通讯录（修改状态）
    //127.0.0.1/frame/system/public/api/update?name=测试&birthday=10.17&QQ=1169849916&number=201830990000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&position=干事
    public function updateAdminModel(Request $request)
    {
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::updateAdmin($request);
            if ($result) {
                return response(array('message'=>'修改成功'));
            } else {
                return response(array('message'=>'修改失败'),403);
            }
        }

    }


    //测试通讯录点击某人名字查询其信息——详细信息
    //127.0.0.1/frame/system/public/api/query?queryName=测试
    public function queryModel(Request $request)
    {
        $result = People::allInfo($request);
        if ($result) {
            return response($result);
        } else {
            return response(array('message' => '查不到'), 403);
        }
    }


    //测试修改自己的信息——基础信息
    //127.0.0.1/frame/system/public/api/updatePeople?name=测试&birthday=10.17&QQ=1169849916&number=201830990000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&position=干事&message=test
    public function updatePeopleModel(Request $request)
    {
        $number = $request->get('number');

        //要登陆
        if (Session::get('flag') != 2) {
            return response(array('message'=>'无权限'),403);
        }else{
            //只能改自己的信息
            if(Session::get('number') == $number){
                $result = People::updatePeople($request);
                if ($result) {
                    return response(array('message'=>'修改成功'));
                } else {
                    return response(array('message'=>'修改失败'),403);
                }

            }else{
                return response(array('message'=>'无权限'),403);
            }
        }

    }

}