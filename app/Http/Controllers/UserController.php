<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller{

    /**
     * 登录
     *
     * @param Request $request->tel
     * @param Request $request->password
     * @return 'message'
     */
    public function login(Request $request){
        $result = User::loginModel($request);
        switch($result){
            case "0":
                Session::put('flag',0); // flag = 0 未登录
                return response(array('message'=>'账号不存在'),401);
                break;
            case "1":
                Session::put('flag',1); // flag = 1 已登录
                Session::put('tel',$request->tel);
                return response(array('message'=>'登录成功'));
                break;
            default:
                Session::put('flag',0);
                return response(array('message' => '用户名或密码错误'), 401);

        }
    }


    /**
     * 注册
     *
     * @param Request $request->name
     * @param Request $request->gender
     * @param Request $request->tel
     * @param Request $request->password
     * @param Request $request->confirmPassword
     * @return 'message'
     *
     * test:
     * http://system.chiukiki.cn/ecg/api/register?name=测试&gender=女&tel=15800000000&password=abc123&confirmPassword=abc123
     */
    public function register(Request $request){
        $password = $request->get('password');
        $confirmPassword = $request->get('confirmPassword');
        if($password == $confirmPassword) {
            $result = User::registerModel($request);
            switch($result){
                case "-1":
                    return response(array('message' => '该手机号已被注册'), 403);
                    break;
                case "1":
                    return response(array('message' => '注册成功'));
                    break;
                default:
                    return response(array('message' => '注册失败'), 403);

            }
        }else return response(array('message' => '密码不一致'), 403);
    }

    /**
     * 获取个人信息
     *
     * @return $result
     *
     * test:
     * http://system.chiukiki.cn/ecg/api/user
     */
    public function user(){
        $userTel = Session::get('tel');
        $result = User::userModel($userTel);
        if ($result) return response($result);
        else return response(array('message' => '无用户信息'), 403);
    }

    /**
     * 修改个人信息
     *
     * @param Request $request->name
     * @param Request $request->gender
     * @param Request $request->birthday
     * @param Request $request->QQ
     * @param Request $request->email
     * @return 'message'
     *
     * test：
     * http://system.chiukiki.cn/ecg/api/update?name=测试&gender=男&birthday=10.17&QQ=1169849916&email=123456@qq.com
     */
    public function update(Request $request){
        $result = User::updateModel($request);
        if ($result) {
            return response(array('message'=>'修改成功'));
        } else {
            return response(array('message'=>'修改失败'),403);
        }
    }

    /**
     * 注销
     *
     * @return 'message'
     *
     * test:
     * http://system.chiukiki.cn/ecg/api/logout
     */
    public function logout(){
        Session::flush();
        return response(array('message'=>'注销成功'));
    }
}
