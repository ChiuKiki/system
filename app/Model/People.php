<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class People extends Model
{
    //登陆，并判断身份
    public static function checkAccount($request){
        $name = $request->get('name');
        $password = $request->get('password');

        $isLogIn=People::where(['name'=>$name,'password'=>$password])->first();
        $isAdministrator1=People::where(['name'=>$name,'password'=>$password,'position'=>'CEO'])->first();
        $isAdministrator2=People::where(['name'=>$name,'password'=>$password,'position'=>'总监'])->first();
        $isAdministrator3=People::where(['name'=>$name,'password'=>$password,'position'=>'部长'])->first();

        //登陆
        if($isLogIn) {
            //判断身份
            if($isAdministrator1||$isAdministrator2||$isAdministrator3){
                return $result="administrator";
            }else{
                return $result="people";
            }
        }else{
            return $result="fail";
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



    //获取某人具体信息（除了id）
    public static function allInfo($personName){
        $result=People::where('name',$personName)
            ->select('name','gender','grade','number','tel','email','school','department','position','password')->get();
        return $result;
    }


    //修改人员信息
    public static function updatePeople($request){
        $name = $request->get('name');
        $gender = $request->get('gender');
        $grade = $request->get('grade');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $position = $request->get('position');
        $password = $request->get('password');

        $row=People::where('name',$name)->first();
        $rowId=isset($row->id)?($row->id):'';     //修改名字所在行的id
        $result = People::where('id', $rowId)->update(
            ['name'=>$name,'gender'=>$gender,'grade'=>$grade,'number'=>$number,
                'tel'=>$tel, 'email'=>$email,'school'=>$school,
                'department'=>$department,'position'=>$position,'password'=>$password]
        );
        return $result;
    }


    //添加人员
    public static function insertPeople($request){
        $name = $request->get('name');
        $gender = $request->get('gender');
        $grade = $request->get('grade');
        $number = $request->get('number');
        $tel = $request->get('tel');
        $email = $request->get('email');
        $school = $request->get('school');
        $department = $request->get('department');
        $position = $request->get('position');
        $password = $request->get('password');

        $result=People::insert(
            ['name'=>$name,'gender'=>$gender,'grade'=>$grade,'number'=>$number,
                'tel'=>$tel, 'email'=>$email,'school'=>$school,
                'department'=>$department,'position'=>$position,'password'=>$password]
        );
        return $result;
    }

}
