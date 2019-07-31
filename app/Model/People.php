<?php

namespace App\Model;

use App\Check;
use Illuminate\Database\Eloquent\Model;


class People extends Model
{
    //登陆，并判断身份——登录
    public static function checkAccount($request){
        $number = $request->get('number');
        $password = $request->get('password');

        $isLogIn=People::where(['number'=>$number,'password'=>$password])->first();
        $isAdministrator1=People::where(['number'=>$number,'password'=>$password,'position'=>'部长'])->first();
        $isAdministrator2=People::where(['number'=>$number,'password'=>$password,'position'=>'副部长'])->first();

        //登陆
        if($isLogIn) {
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


    //获取学院人员名单
    public static function querySchool($queryName){
        $matchInfo = People::where('school', $queryName)->get('name');
        //前端需要形如{name:["1","2","3"]}的结果
        $arr = array();
        foreach ($matchInfo as $nameList){
            array_push($arr,$nameList->name);
        }
        $result=array('name'=>$arr);
        return $result;

    }


    //获取部门人员名单
    public static function queryDepartment($queryName){
        $matchInfo = People::where('department', $queryName)->get('name');
        //前端需要形如{name:["1","2","3"]}的结果
        $arr = array();
        foreach ($matchInfo as $nameList) {
            array_push($arr, $nameList->name);
        }
        $result = array('name' => $arr);
        return $result;
    }


    //初始时获取姓名、部门、职位信息并按部门、职位顺序显示——百步梯通讯录
    public static function queryInitial($request){

        /*
        //获取姓名、部门、职位信息
        $nameInfo = People::where('name', $query)->select('name','department','position')->get();
        $departmentInfo = People::where('department', $query)->select('name','department','position')->get();
        $positionInfo = People::where('position', $query)->select('name','department','position')->get();
*/


    }


    //获取姓名、部门、职位信息——百步梯通讯录
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


    //根据姓名、部门获取所有信息——百步梯通讯录（修改状态）
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


    //获取某人所有信息
    public static function allInfo($personName){
        $result=People::where('name',$personName)
            ->select('name','birthday', 'QQ','number','tel','email','school','department','position')->get();
        return $result;
    }


    //修改人员信息
    public static function updatePeople($request){
        $name = $request->get('name');
        //$gender = $request->get('gender');
        //$grade = $request->get('grade');
        $birthday = $request->get('birthday');
        $QQ = $request->get('QQ');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $position = $request->get('position');
        $password = $request->get('password');


        //不能改学号！
        $checkResult=Check::checkName($name)&&/*Check::checkGender($gender)&&*/
            Check::checkQQ($QQ)&& Check::checkTel($tel)&&Check::checkBirthday($birthday)&&
            Check::checkEmail($email)&& Check::checkSchool($school) &&Check::checkDepartment($department)&&
            Check::checkPosition($position)&&Check::checkPassword($password);

        if($checkResult) {
            $row = People::where('number', $number)->first();
            $rowId = isset($row->id) ? ($row->id) : '';     //修改学号所在行的id
            $result = People::where('id', $rowId)->update(
                ['name' => $name, /*'gender' => $gender, 'grade' => $grade,*/'birthday'=>$birthday,'QQ'=>$QQ,
                    'tel' => $tel, 'email' => $email, 'school' => $school, 'department' => $department,
                    'position' => $position, 'password' => $password]
            );
            return $result;
        }else{
            return $result=0;
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


    //学号是否已存在
    public static function isNumberExist($number){
        $result = People::where(['number'=>$number])->first();
        return $result;
    }


    //删除人员——百步梯通讯录（修改状态）
    public static function deletePeople($request){

        //根据学号删除
        $arr = $request->get('number');
        $len = sizeof($arr);
        $result = 0;
        for($i = 0; $i < $len ; $i++){
            $number = $arr[$i];
            $result = People::where('number', $number)->delete();
        }
        return $result;

    }


}
