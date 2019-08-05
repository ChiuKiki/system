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
        //0:未登录     1:已登录且为管理员   2:已登录且为普通人员
        switch($result){

            case "administrator":
                Session::put('flag',1);
                Session::save();
                return response(array(['message'=>'登陆成功','identity'=>'administrator']));
                break;

            case "people":
                Session::put('flag',2);
                Session::save();
                return response(array(['message'=>'登陆成功','identity'=>'people']));
                break;

            default:
                Session::put('flag',0);
                Session::save();
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
    //http://system.chiukiki.cn/api/forgetPassword?number=201830250000&tel=13400000000&setPassword=123456
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
    //http://system.chiukiki.cn/api/operatorLogout
    public function logoutModel(Request $request)
    {
        Session::flush();
        return response(array('message'=>'注销成功'));

    }


    //测试首页显示信息——百步梯通讯录
    //http://system.chiukiki.cn/api/queryInitial
    public function queryInitialModel(Request $request){
        //要登陆
        if (Session::get('flag') == 0) {
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


    //测试搜索框查询1——百步梯通讯录
    //http://system.chiukiki.cn/api/queryInfo?query=技术部
    public function queryInfoModel(Request $request){
        return response(Session::get('flag'));
        /*
        //要登陆
        if (Session::get('flag') == 0) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::queryInfo($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
        */
    }


    //测试搜索框查询2——百步梯通讯录（修改状态）
    //http://system.chiukiki.cn/api/queryInfoAdmin?query=技术部
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


    //测试管理员获取他人信息——百步梯通讯录（修改状态）
    //http://system.chiukiki.cn/api/queryAdmin?queryNumber=201830255555
    public function queryAdminModel(Request $request){
        //要管理员权限
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::queryAdmin($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
    }


    //测试批量删除——百步梯通讯录（修改状态）
    //http://system.chiukiki.cn/api/delete?number[]=201830660000&number[]=201830770000&number[]=201830880000
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


    //测试通讯录点击某人名字查询其信息——详细信息
    //http://system.chiukiki.cn/api/query?queryName=b
    public function queryModel(Request $request)
    {
        if (Session::get('flag') == 0) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::allInfo($request);
            if ($result) {
                return response($result);
            } else {
                return response(array('message' => '查不到'), 403);
            }
        }
    }


    //测试获取自己信息——个人信息
    //http://system.chiukiki.cn/api/queryNumber?queryNumber=201830250000
    public function queryNumberModel(Request $request)
    {
        $number = $request->get('queryNumber');

        //要登陆
        if (Session::get('flag') == 0) {
            return response(array('message'=>'无权限'),403);
        }else {
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
    }


    //测试修改信息——个人信息&百步梯通讯录（修改状态）
    //http://system.chiukiki.cn/api/updatePeople?name=测试&birthday=10.17&QQ=1169849916&number=201830990000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&position=干事&message=test
    public function updatePeopleModel(Request $request)
    {
        $number = $request->get('number');

        switch (Session::get('flag')){
            //未登录
            case "0":
                return response(array('message'=>'无权限'),403);
                break;
            //管理员
            case "1":
                $result = People::updateAdmin($request);
                break;
            //普通人员
            case "2":
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