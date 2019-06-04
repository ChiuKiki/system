<?php

namespace App\Http\Controllers;

use App\Model\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

session_start();

class PeopleController extends Controller
{
    public $flag;

    public function checkModel()
    {
        //测试登陆
        //127.0.0.1/frame/system/public/operatorLogin?user=root&password=123456
        $user = Input::get('user');
        $password = Input::get('password');

        $result = People::checkAccount($user, $password);

        if ($result) {
            $_SESSION['flag'] = 1;
            header('HTTP/1.1 200 OK');
            return json_encode("登陆成功");
        } else {
            $_SESSION['flag'] = 0;
            header('HTTP/1.1 401 Unauthorized');
            exit(json_encode("用户名或密码错误"));
        }
    }


    public function readModel($choice)
    {
        $queryName = Input::get('queryName');
        switch ($choice) {

            case "1":
                //测试学院查询
                //http://127.0.0.1/frame/system/public/query/1?queryName=电信
                $result = People::querySchool($queryName);
                if ($result->isEmpty()) {
                    header('HTTP/1.1 403 Forbidden');
                    return json_encode("无此学院");
                } else {
                    header('HTTP/1.1 200 OK');
                    return json_encode($result);
                }
                break;


            case "2":
                //测试部门查询
                //http://127.0.0.1/frame/system/public/query/2?queryName=部门1
                $result = People::queryDepartment($queryName);
                if ($result->isEmpty()) {
                    header('HTTP/1.1 403 Forbidden');
                    return json_encode("无此部门");
                } else {
                    header('HTTP/1.1 200 OK');
                    return json_encode($result);
                }
                break;

            default:
                exit(json_encode("查什么？？？？"));
        }
    }


    public function updateModel()
    {
        //测试修改
        //http://127.0.0.1/frame/system/public/update?name=t&gender=女&grade=2018级&number=2018&tel=17800000000&email=84@qq.com&school=电信&department=部门1&position=学生
        $name = Input::get('name');
        $gender = Input::get('gender');
        $grade = Input::get('grade');
        $number = Input::get('number');
        $tel = Input::get('tel');
        $email = Input::get('email');
        $school = Input::get('school');
        $department = Input::get('department');
        $position = Input::get('position');

        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        if ($_SESSION['flag'] != 1) {
            header('HTTP/1.1 401 Unauthorized');
            exit(json_encode("无权限"));
        } else {
            $result = People::updatePeople($name, $gender, $grade, $number, $tel, $email, $school, $department, $position);
            if ($result) {
                header('HTTP/1.1 200 OK');
                return json_encode("修改成功");
            } else {
                header('HTTP/1.1 403 Forbidden');
                return json_encode("失败");
            }
        }
    }


    public function insertModel()
    {
        //测试添加
        // http://127.0.0.1/frame/system/public/insert?name=kiki&gender=男&grade=2018级&number=2018&tel=13600000000&email=8400@qq.com&school=学院1&department=部门2&position=学生
        $name = Input::get('name');
        $gender = Input::get('gender');
        $grade = Input::get('grade');
        $number = Input::get('number');
        $tel = Input::get('tel');
        $email = Input::get('email');
        $school = Input::get('school');
        $department = Input::get('department');
        $position = Input::get('position');

        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        if ($_SESSION['flag'] != 1) {
            header('HTTP/1.1 401 Unauthorized');
            exit(json_encode("无权限"));
        } else {
            $result = People::insertPeople($name, $gender, $grade, $number, $tel, $email, $school, $department, $position);
            if ($result) {
                header('HTTP/1.1 200 OK');
                return json_encode("添加成功");
            } else {
                header('HTTP/1.1 403 Forbidden');
                return json_encode("失败");
            }
        }
    }


    public function insert_administrator_Model()
    {
        //测试添加
        // http://127.0.0.1/frame/system/public/register?name=kk&password=123
        $name = Input::get('name');
        $password = Input::get('password');

        $_SESSION['flag'] = isset($_SESSION['flag']) ? $_SESSION['flag'] : "";

        if ($_SESSION['flag'] != 1) {
            header('HTTP/1.1 401 Unauthorized');
            exit(json_encode("无权限"));
        } else {
            $result = People::insertAdministrator($name, $password);
            if ($result) {
                header('HTTP/1.1 200 OK');
                return json_encode("添加成功");
            } else {
                header('HTTP/1.1 403 Forbidden');
                return json_encode("失败");
            }
        }
    }
}