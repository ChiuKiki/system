<?php

namespace App\Model;

use App\Check;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class People extends Model
{
    public $timestamps = false;

    //登录
    public static function checkAccount($request){
        $number = $request->get('number');
        $password = $request->get('password');

        $isLogIn = People::where(['number'=>$number,'password'=>$password])->first();

        //账号是否存在
        if(self::isNumberExist($number)) {
            //登陆
            if ($isLogIn) {
                //设置session
                Session::put('number', $number);
                return $result = "ok";
            } else {
                return $result = "fail";
            }
        }else{
            return $result = "notExist";
        }
    }


    //注册
    public static function insertPeople($request){
        $name = $request->get('name');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $department = $request->get('department');
        $password = $request->get('password');
        $result1 = 0;

        $checkResult=Check::checkName($name)&& Check::checkNumber($number)&& Check::checkTel($tel)
            && Check::checkDepartment($department)&&Check::checkPassword($password);

        $table = ['timetable1','timetable2','timetable3','timetable4','timetable5','timetable6','timetable7',
            'timetable8','timetable9','timetable10','timetable11','timetable12','timetable13','timetable14',
            'timetable15','timetable16','timetable17','timetable18'];

        if($checkResult){
            //在people表中插入
            $result0=People::insert(
                ['name'=>$name, 'number'=>$number, 'tel'=>$tel,
                    'department'=>$department,'password'=>$password]
            );
            //在timetable表中插入
            for($i = 0; $i < 18; $i++){
                $result1=DB::table($table[$i])->insert(
                    ['name'=>$name,'number'=>$number,'department'=>$department]
                );
            }

            if($result0&&$result1){
                return $result=1;
            }else{
                return $result=0;
            }
        }else{
            return $result=0;
        }
    }


    //学号是否已存在
    public static function isNumberExist($number){
        $result = People::where(['number'=>$number])->first();
        return $result;
    }


    //找回密码
    public static function findPassword($request){
        $number = $request->get('number');
        $tel = $request->get('tel');
        $setPassword = $request->get('setPassword');
        //通过手机号找回密码
        $isCorrect =  People::where(['number'=>$number,'tel'=>$tel])->first();

        //判断学号是否存在
        if(self::isNumberExist($number)) {
            //判断手机号与学号是否匹配
            if ($isCorrect) {
                //判断新密码是否与旧密码一样
                $samePassword = People::where(['password' => $setPassword])->first();
                if ($samePassword) {  //一样，不用update
                    return 1;
                } else {     //不同，要update
                    $result = People::where(['number' => $number])
                        ->update(['password' => $setPassword]);
                    return $result;
                }
            } else {
                return -1;  //手机号与学号不匹配
            }
        }else{
            return -2;  //学号不存在
        }
    }



    //普通人员修改自己信息——个人信息
    public static function updatePeople($request){
        $name = $request->get('name');
        $birthday = $request->get('birthday');
        $QQ = $request->get('QQ');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $message = $request->get('message');

        //不改密码、学号；改'message'
        $checkResult=Check::checkName($name)&& Check::checkQQ($QQ) && Check::checkTel($tel)
            &&Check::checkBirthday($birthday)&& Check::checkEmail($email) && Check::checkSchool($school)
            &&Check::checkDepartment($department);

        $table = ['timetable1','timetable2','timetable3','timetable4','timetable5','timetable6','timetable7',
            'timetable8','timetable9','timetable10','timetable11','timetable12','timetable13','timetable14',
            'timetable15','timetable16','timetable17','timetable18'];

        if($checkResult) {
            //在people表中修改
            $result = People::where('number', Session::get('number'))->update(
                ['name' => $name, 'birthday' => $birthday, 'QQ' => $QQ, 'tel' => $tel,
                    'email' => $email, 'school' => $school, 'department' => $department, 'message' => $message]
            );
            //在timetable表中修改
            for($i = 0; $i < 18; $i++){
                $result1 = DB::table($table[$i])
                    ->where('number',Session::get('number'))
                    ->update(['name'=>$name,'department'=>$department]);
            }
            return $result;
        }else{
            return 0;
        }
    }


    //点击某人姓名获取其所有信息——详细信息
    public static function allInfo($request){
        $queryName = $request->get('queryName');
        $result=People::where('name',$queryName)
            ->select('name','school','department','birthday','tel', 'QQ','email','number','message')->get();
        return $result;
    }


    //获取自己信息——个人信息
    public static function allInfoNumber($request){
        $queryNumber = $request->get('queryNumber');
        $result=People::where('number',$queryNumber)
            ->select('name','school','department','birthday','tel', 'QQ','email','number','message')
            ->get();
        return $result;
    }
}
