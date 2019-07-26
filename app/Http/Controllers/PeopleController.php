<?php

namespace App\Http\Controllers;

use App\Model\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PeopleController extends Controller
{
    //测试登陆
    //127.0.0.1/frame/system/public/api/operatorLogin?name=b&password=abc000
    public function loginModel(Request $request)
    {
        $result = People::checkAccount($request);

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


    //测试注销
    //127.0.0.1/frame/system/public/api/operatorLogout
    public function logoutModel(Request $request)
    {
        Session::flush();
        return response(array('message'=>'注销成功'));

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


    //测试学院查询
    //127.0.0.1/frame/system/public/api/query?choice=1&queryName=电信
    //测试部门查询
    //127.0.0.1/frame/system/public/api/query?choice=2&queryName=技术部
    public function queryModel(Request $request)
    {
        $choice = $request->get('choice');
        $queryName = $request->get('queryName');
        $personName = $request->get('personName');

        if ($choice!=""&&$personName=="") {
            switch ($choice) {

                case "1":
                    $result = People::querySchool($queryName);
                    if ($result==null) {
                        return response(array('message' => '无此学院'), 403);
                    } else {
                        return response($result);
                    }
                    break;


                case "2":
                    $result = People::queryDepartment($queryName);
                    if ($result==null) {
                        return response(array('message' => '无此部门'), 403);
                    } else {
                        return response($result);
                    }
                    break;

                default:
                    return response(array('message' => '查什么？？？？'), 403);
            }

        } elseif ($personName!=""&&$choice=="") {

            //测试获取某人具体信息
            //http://127.0.0.1/frame/system/public/api/query?personName=a
            if (Session::get('flag') != 1) {
                return response(array('message' => '无权限'), 403);
            } else {
                $result = People::allInfo($personName);
                if ($result) {
                    return response($result);
                } else {
                    return response(array('message' => '查无此人'), 403);
                }
            }
        }else{
            return response('操作失败');
        }
    }


    //测试修改
    //127.0.0.1/frame/system/public/api/update?name=赵绮琪&gender=女&grade=2018级&number=201830250000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&position=CEO&password=abc123
    public function updateModel(Request $request)
    {
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::updatePeople($request);
            if ($result) {
                return response(array('message'=>'修改成功'));
            } else {
                return response(array('message'=>'修改失败'),403);
            }
        }

    }


    //测试添加
    //127.0.0.1/frame/system/public/api/insert?name=赵绮琪&gender=女&grade=2018级&number=201830250000&tel=15800000000&email=123456@qq.com&school=电子与信息学院&department=技术部&position=CEO&password=abc123
    public function insertModel(Request $request)
    {
        if (Session::get('flag') != 1) {
            return response(array('message'=>'无权限'),403);
        } else {
            $result = People::insertPeople($request);
            if ($result) {
                return response(array('message'=>'添加成功'));
            } else {
                return response(array('message'=>'添加失败'),403);
            }
        }
    }


    //测试删除
    //127.0.0.1/frame/system/public/api/delete?name=赵绮琪
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


}