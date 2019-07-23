<?php

namespace App\Http\Controllers;

use App\Model\People;
use Illuminate\Http\Request;

session_start();

class PeopleController extends Controller
{
    public $flag;

    public function checkModel(Request $request)
    {
        //测试登陆
        //127.0.0.1/frame/system/public/api/operatorLogin?user=root&password=123456
        $result = People::checkAccount($request);

        switch($result){

            case "administrator":
                $_SESSION['flag'] = 1;
                return response(array(['message'=>'登陆成功','identity'=>'administrator']));
                break;

            case "people":
                $_SESSION['flag'] = 0;
                return response(array(['message'=>'登陆成功','identity'=>'people']));
                break;

            default:
                $_SESSION['flag'] = 0;
                return response(array('message' => '用户名或密码错误'), 401);

        }
    }


    public function insert_administrator_Model(Request $request)
    {
        //测试注册
        // http://127.0.0.1/frame/system/public/api/register?name=kk&password=123
        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        $result = People::insertAdministrator($request);
        if ($result) {
            return response(array('message'=>'注册成功'));
        } else {
            return response(array('message'=>'注册失败'),403);
        }
    }


    public function readModel(Request $request)
    {
        $choice = $request->get('choice');
        $queryName = $request->get('queryName');
        $personName = $request->get('personName');

        if ($choice!=""&&$personName=="") {
            switch ($choice) {

                case "1":
                    //测试学院查询
                    //http://127.0.0.1/frame/system/public/api/query?choice=1&queryName=电信
                    $result = People::querySchool($queryName);
                    if ($result==null) {
                        return response(array('message' => '无此学院'), 403);
                    } else {
                        return response($result);
                    }
                    break;


                case "2":
                    //测试部门查询
                    //http://127.0.0.1/frame/system/public/api/query?choice=2&queryName=部门1
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
            //http://127.0.0.1/frame/system/public/api/query?personName=t
            $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

            if ($_SESSION['flag'] != 1) {
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




    public function updateModel(Request $request)
    {
        //测试修改
        //http://127.0.0.1/frame/system/public/api/update?name=t&gender=女&grade=2018级&number=2018&tel=17800000000&email=84@qq.com&school=电信&department=部门1&position=学生&password=1111111
        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        if ($_SESSION['flag'] != 1) {
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


    public function insertModel(Request $request)
    {
        //测试添加
        // http://127.0.0.1/frame/system/public/api/insert?name=kiki&gender=男&grade=2018级&number=2018&tel=13600000000&email=8400@qq.com&school=学院1&department=部门2&position=学生&password=asdfgdfg
        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        if ($_SESSION['flag'] != 1) {
            return response(array('message'=>'无权限'),401);
        } else {
            $result = People::insertPeople($request);
            if ($result) {
                return response(array('message'=>'添加成功'));
            } else {
                return response(array('message'=>'添加失败'),403);
            }
        }
    }


}