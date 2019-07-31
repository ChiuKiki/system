<?php

namespace App\Model;

use App\Check;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class People extends Model
{
    public $timestamps = false;

    //登陆，并判断身份——登录
    public static function checkAccount($request){
        $number = $request->get('number');
        $password = $request->get('password');

        $isLogIn=People::where(['number'=>$number,'password'=>$password])->first();
        $isAdministrator1=People::where(['number'=>$number,'password'=>$password,'position'=>'部长'])->first();
        $isAdministrator2=People::where(['number'=>$number,'password'=>$password,'position'=>'副部长'])->first();

        //登陆
        if($isLogIn) {
            //设置session
            Session::put('number',$number);
            //判断身份
            if($isAdministrator1||$isAdministrator2){
                return $result="administrator";
            }else{
                return $result="people";
            }
        }else{
            return $result="fail";
        }
    }


    //添加人员——注册
    public static function insertPeople($request){
        $name = $request->get('name');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $department = $request->get('department');
        $password = $request->get('password');

        $checkResult=Check::checkName($name)&& Check::checkNumber($number)&& Check::checkTel($tel)
            && Check::checkDepartment($department)&&Check::checkPassword($password);

        if($checkResult){
            $firstResult=People::insert(
                ['name'=>$name, 'number'=>$number, 'tel'=>$tel,
                    'department'=>$department,'password'=>$password]
            );
            $secondResult=Timetable::insert(
                ['name'=>$name,'number'=>$number]
            );
            if($firstResult&&$secondResult){
                return $result=1;
            }else{
                return $result=0;
            }
        }else{
            return $result=0;
        }
    }


    //学号是否已存在——注册
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

        if($isCorrect){
            $result = People::where(['number'=>$number])->update(['password'=>$setPassword]);
            return $result;
        }else{
            return $result=0;
        }
    }


    //初始时获取姓名、部门、职位信息并按部门、职位顺序显示——百步梯通讯录
    public static function queryInitial($request){
        $allInfo = People::select('name','department','position')       //获取所有人的姓名、部门、职位信息
            //->orderBy('department','ASC')                               //按部门升序
            ->orderBy(DB::raw('convert(`department` using gbk)'))  //部门按汉字首字母降序    把技术部顶上去>__<
            ->orderBy(DB::raw('convert(`position` using gbk)'))  //职位按汉字首字母降序
            ->get();
        return $allInfo;
    }


    //搜索框：根据姓名、部门、职位获取信息——百步梯通讯录
    public static function queryInfo($request){
        $query = $request->get('query');
        //判断输入的是姓名、部门、还是职位
        $isName = People::where('name', $query)->first();
        $isDepartment = People::where('department', $query)->first();
        $isPosition = People::where('position', $query)->first();
        //获取姓名、部门、职位信息
        $nameInfo = People::where('name', $query)->select('name','department','position')->get();
        $departmentInfo = People::where('department', $query)->select('name','department','position')->get();
        $positionInfo = People::where('position', $query)->select('name','department','position')->get();

        if($isName){
            return $nameInfo;

        }elseif ($isDepartment){
            return $departmentInfo;

        }elseif ($isPosition){
            return $positionInfo;

        }else{
            return 0;
        }

    }


    //搜索框：根据姓名、部门获取所有信息——百步梯通讯录（修改状态）
    public static function queryInfoAdmin($request){
        $query = $request->get('query');
        //判断输入的是姓名还是部门
        $isName = People::where('name', $query)->first();
        $isDepartment = People::where('department', $query)->first();
        //获取所有信息
        $nameInfo = People::where('name', $query)->select('name','department','birthday','tel','QQ','email','number','school','position','password')->get();
        $departmentInfo = People::where('department', $query)->select('name','department','birthday','tel','QQ','email','number','school','position','password')->get();

        if($isName){
            return $nameInfo;
        }elseif ($isDepartment){
            return $departmentInfo;
        }else{
            return 0;
        }
    }


    //批量删除人员——百步梯通讯录（修改状态）
    public static function deletePeople($request){
        //根据学号删除
        $arr = $request->get('number');
        $len = sizeof($arr);
        $result = 0;
        for($i = 0; $i < $len ; $i++){
            $number = $arr[$i];
            $result1 = People::where('number', $number)->delete();
            $result2 = Timetable::where('number', $number)->delete();
            $result = $result1&$result2;
        }
        return $result;
    }


    //修改人员信息——百步梯通讯录（修改状态）
    public static function updateAdmin($request){
        $name = $request->get('name');
        $birthday = $request->get('birthday');
        $QQ = $request->get('QQ');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $position = $request->get('position');

        //不改密码
        $checkResult=Check::checkName($name)&&Check::checkNumber($number)&& Check::checkQQ($QQ)
            && Check::checkTel($tel)&&Check::checkBirthday($birthday)&& Check::checkEmail($email)
            && Check::checkSchool($school) &&Check::checkDepartment($department)&& Check::checkPosition($position);

        if($checkResult) {
            $result = People::where('number', $number)->update(
                ['name' => $name, 'birthday' => $birthday, 'QQ' => $QQ, 'number' => $number,
                    'tel' => $tel, 'email' => $email, 'school' => $school, 'department' => $department,
                    'position' => $position]
            );
            return $result;
        }else{
            return $result=0;
        }
    }


    //点击某人姓名获取其所有信息——详细信息
    public static function allInfo($request){
        $queryName = $request->get('queryName');
        $result=People::where('name',$queryName)
            ->select('name','birthday', 'QQ','number','tel','email','school','department','position','message')->get();
        return $result;
    }


    //修改自己信息——基础信息
    public static function updatePeople($request){
        $name = $request->get('name');
        $birthday = $request->get('birthday');
        $QQ = $request->get('QQ');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $position = $request->get('position');
        $message = $request->get('message');

        //不改密码、学号；改'message'
        $checkResult=Check::checkName($name)&& Check::checkQQ($QQ) && Check::checkTel($tel)
            &&Check::checkBirthday($birthday)&& Check::checkEmail($email) && Check::checkSchool($school)
            &&Check::checkDepartment($department)&& Check::checkPosition($position);

        if($checkResult) {
            $result = People::where('number', Session::get('number'))->update(
                ['name' => $name, 'birthday' => $birthday, 'QQ' => $QQ, 'tel' => $tel,
                    'email' => $email, 'school' => $school, 'department' => $department,
                    'position' => $position, 'message' => $message]
            );
            return $result;
        }else{
            return $result=0;
        }
    }


}
