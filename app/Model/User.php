<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class User extends Model
{
    /**
     * 登录
     *
     * @param Request $request->tel
     * @param Request $request->password
     * @return $result
     */
    public static function loginModel($request){
        $tel = $request->get('tel');
        $password = $request->get('password');

        $isTelExist = User::where(['tel'=>$tel])->first();
        if(!$isTelExist) return $result = 0;

        $match = User::where(['tel'=>$tel,'password'=>$password])->first();
        if($match) {
            Session::put('tel', $tel);  // 保持session
            return $result = 1;
        }else return $result = -1;
    }

    /**
     * 注册
     *
     * @param $request->name
     * @param $request->gender
     * @param $request->tel
     * @param $request->password
     * @return $result
     */
    public static function registerModel($request){
        $name = $request->get('name');
        $gender = $request->get('gender');
        $tel = $request->get('tel');
        $password = $request->get('password');

        $isTelExist = User::where(['tel'=>$tel])->first();
        if($isTelExist) return $result = -1;

        $checkResult=Check::checkName($name)&&Check::checkGender($gender)
                        &&Check::checkTel($tel)&&Check::checkPassword($password);
        if($checkResult){
            User::insert(['name'=>$name, 'gender'=>$gender, 'tel'=>$tel,'password'=>$password]);
            return $result = 1;
        }else return $result = 0;
    }

    /**
     * 获取个人信息
     *
     * @param $userTel
     * @return $result
     */
    public static function userModel($userTel){
        $result=User::where('tel',$userTel)
            ->select('name','gender','birthday','tel', 'QQ','email')
            ->get();
        return $result;
    }

    /**
     * 修改个人信息
     *
     * @param $request->name
     * @param $request->gender
     * @param $request->birthday
     * @param $request->QQ
     * @param $request->email
     * @return $result
     */
    public static function updateModel($request){
        $name = $request->get('name');
        $gender = $request->get('gender');
        $birthday = $request->get('birthday');
        $QQ = $request->get('QQ');
        $email = $request->get('email');
        // 不改密码、手机号
        $checkResult=Check::checkName($name) && Check::checkGender($gender) && Check::checkBirthday($birthday)
            && Check::checkQQ($QQ) && Check::checkEmail($email);
        if($checkResult) {
            $result = User::where('tel', Session::get('tel'))->update(
                ['name' => $name, 'gender' => $gender, 'birthday' => $birthday, 'QQ' => $QQ, 'email' => $email]
            );
            return $result;
        }else return $result = 0;
    }

}
