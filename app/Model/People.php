<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class People extends Model
{
    //登陆，并判断身份
    public static function checkAccount($request){
        $user = $request->get('user');
        $password = $request->get('password');
        $isAdministrator=DB::table('administrator')->where(['name'=>$user,'password'=>$password])->first();
        $isPeople=DB::table('people')->where(['name'=>$user,'password'=>$password])->first();

        if($isAdministrator){
            return $result="administrator";
        }
        elseif($isPeople){
            return $result="people";
        }
        else{
            return $result="fail";
        }
    }


    //管理员注册
    public static function insertAdministrator($request){
        $name = $request->get('name');
        $password = $request->get('password');

        $result = DB::table('administrator')->insert(
            ['name' => $name, 'password' => $password]
        );
        return $result;
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
