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
            $result = People::where(['number'=>$number])
                ->update(['password'=>$setPassword]);
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


    //搜索框1：根据姓名、部门、职位获取信息——百步梯通讯录
    public static function queryInfo($request){
        $query = $request->get('query');
        //判断输入的是姓名、部门、还是职位
        $isName = People::where('name', $query)->first();
        $isDepartment = People::where('department', $query)->first();
        $isPosition = People::where('position', $query)->first();
        //获取姓名、部门、职位信息
        $nameInfo = People::where('name', $query)
            ->select('name','department','position')
            ->orderBy(DB::raw('convert(`department` using gbk)'))
            ->orderBy(DB::raw('convert(`position` using gbk)'))
            ->get();
        $departmentInfo = People::where('department', $query)
            ->select('name','department','position')
            ->orderBy(DB::raw('convert(`department` using gbk)'))
            ->orderBy(DB::raw('convert(`position` using gbk)'))
            ->get();
        $positionInfo = People::where('position', $query)
            ->select('name','department','position')
            ->orderBy(DB::raw('convert(`department` using gbk)'))
            ->orderBy(DB::raw('convert(`position` using gbk)'))
            ->get();

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


    //搜索框2：根据姓名、部门获取所有信息——百步梯通讯录（修改状态）
    public static function queryInfoAdmin($request){
        $query = $request->get('query');
        //判断输入的是姓名还是部门
        $isName = People::where('name', $query)->first();
        $isDepartment = People::where('department', $query)->first();
        //获取所有信息
        $nameInfo = People::where('name', $query)
            ->select('name','department','birthday','tel','QQ','email','number','school','position')
            ->orderBy(DB::raw('convert(`department` using gbk)'))
            ->orderBy(DB::raw('convert(`position` using gbk)'))
            ->get();
        $departmentInfo = People::where('department', $query)
            ->select('name','department','birthday','tel','QQ','email','number','school','position')
            ->orderBy(DB::raw('convert(`department` using gbk)'))
            ->orderBy(DB::raw('convert(`position` using gbk)'))
            ->get();

        if($isName){
            return $nameInfo;
        }elseif ($isDepartment){
            return $departmentInfo;
        }else{
            return 0;
        }
    }


    //管理员点击“修改”时，根据学号获取所有信息——百步梯通讯录（修改状态）
    public static function queryAdmin($request){
        $queryNumber = $request->get('queryNumber');
        //获取所有信息
        $matchInfo = People::where('number', $queryNumber)
            ->select('name','department','position','tel','QQ','email','school','number','birthday')
            ->get();

        if($matchInfo){
            return $matchInfo;
        }else{
            return 0;
        }
    }


    //批量删除人员——百步梯通讯录（修改状态）
    public static function deletePeople($request){
        //根据学号删除
        $arr = $request->get('number');
        $len = sizeof($arr);
        $result0 = 0;
        $result1 = 0;
        $table = ['timetable1','timetable2','timetable3','timetable4','timetable5','timetable6','timetable7',
            'timetable8','timetable9','timetable10','timetable11','timetable12','timetable13','timetable14',
            'timetable15','timetable16','timetable17','timetable18'];

        for($i = 0; $i < $len ; $i++){
            $number = $arr[$i];
            //在people表中删除
            $result0 = People::where('number', $number)
                ->delete();
            //在timetable表中删除
            for($j = 0; $j < 18; $j++){
                $result1 = DB::table($table[$j])
                    ->where('number', $number)
                    ->delete();
            }
        }
        return $result0&$result1;
    }


    //管理员修改人员信息——百步梯通讯录（修改状态）
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
        $message = $request->get('message');

        //不改密码
        $checkResult=Check::checkName($name)&&Check::checkNumber($number)&& Check::checkQQ($QQ)
            && Check::checkTel($tel)&&Check::checkBirthday($birthday)&& Check::checkEmail($email)
            && Check::checkSchool($school) &&Check::checkDepartment($department)&& Check::checkPosition($position);

        $table = ['timetable1','timetable2','timetable3','timetable4','timetable5','timetable6','timetable7',
            'timetable8','timetable9','timetable10','timetable11','timetable12','timetable13','timetable14',
            'timetable15','timetable16','timetable17','timetable18'];

        //根据学号修改
        if($checkResult) {
            //在people表中修改
            $result = People::where('number', $number)->update(
                ['name' => $name, 'birthday' => $birthday, 'QQ' => $QQ, 'number' => $number,
                    'tel' => $tel, 'email' => $email, 'school' => $school, 'department' => $department,
                    'position' => $position,'message' => $message]
            );
            //在timetable表中修改
            for($i = 0; $i < 18; $i++){
                $result1 = DB::table($table[$i])
                    ->where('number',$number)
                    ->update(['name'=>$name,'department'=>$department]);
            }
            return $result;
        }else{
            return 0;
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
        $position = $request->get('position');
        $message = $request->get('message');

        //不改密码、学号；改'message'
        $checkResult=Check::checkName($name)&& Check::checkQQ($QQ) && Check::checkTel($tel)
            &&Check::checkBirthday($birthday)&& Check::checkEmail($email) && Check::checkSchool($school)
            &&Check::checkDepartment($department)&& Check::checkPosition($position);

        $table = ['timetable1','timetable2','timetable3','timetable4','timetable5','timetable6','timetable7',
            'timetable8','timetable9','timetable10','timetable11','timetable12','timetable13','timetable14',
            'timetable15','timetable16','timetable17','timetable18'];

        if($checkResult) {
            //在people表中修改
            $result = People::where('number', Session::get('number'))->update(
                ['name' => $name, 'birthday' => $birthday, 'QQ' => $QQ, 'tel' => $tel,
                    'email' => $email, 'school' => $school, 'department' => $department,
                    'position' => $position, 'message' => $message]
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
            ->select('name','school','department','position','birthday','tel', 'QQ','email','number','message')->get();
        return $result;
    }


    //获取自己信息——个人信息
    public static function allInfoNumber($request){
        $queryNumber = $request->get('queryNumber');
        $result=People::where('number',$queryNumber)
            ->select('name','school','department','position','birthday','tel', 'QQ','email','number','message')
            ->get();
        return $result;
    }
}
