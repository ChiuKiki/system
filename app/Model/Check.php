<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
//  检查姓名：
//    1.汉字或“·”，
//    2.长度：每部分1-10字
    public static function checkName($name){
        $pattern='/^[\x{4e00}-\x{9fa5}]{1,10}+(·[\x{4e00}-\x{9fa5}]{1,10}+)*$/u';
        if(preg_match($pattern,$name)){
            return true;
        }else{
            return false;
        }
    }


//  检查生日：
//    1-2位数.1-2位数
    public static function checkBirthday($birthday){
        $pattern='/^[0-9]{1,2}+.[0-9]{1,2}$/';
        if(preg_match($pattern,$birthday)){
            return true;
        }else{
            return false;
        }
    }


//  检查QQ：
//    5-11位数
    public static function checkQQ($QQ){
        $pattern='/^\d{5,11}$/';
        if(preg_match($pattern,$QQ)){
            return true;
        }else{
            return false;
        }
    }

//  检查姓别：男或女
    public static function checkGender($gender){
        $pattern='/^[\x{7537}|\x{5973}]{1}$/u';
        if(preg_match($pattern,$gender)){
            return true;
        }else{
            return false;
        }
    }


//  检查学号：
//    1.以20开头
//    2.后面10位数
    public static function checkNumber($number){
        $pattern='/^20\d{10}$/';
        if(preg_match($pattern,$number)){
            return true;
        }else{
            return false;
        }
    }


//  检查手机号：
//    1.以1开头
//    2.后面10位数
    public static function checkTel($tel){
        $pattern='/^1\d{10}$/';
        if(preg_match($pattern,$tel)){
            return true;
        }else{
            return false;
        }
    }


//  检查邮箱：
//    1.@之前必须有内容且只能是字母（大小写）、数字、下划线(_)、减号（-）、点（.）
//    2.@和最后一个点（.）之间必须有内容且只能是字母（大小写）、数字、点（.）、减号（-），且两个点不能挨着
//    3.最后一个点（.）之后必须有内容且内容只能是字母（大小写）、数字且长度为大于等于2个字节，小于等于6个字节
    public static function checkEmail($email){
        $pattern='/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/';
        if(preg_match($pattern,$email)){
            return true;
        }else{
            return false;
        }
    }


//  检查学院：
//    1.汉字；
//    2.以“学院”结尾
    public static function checkSchool($school){
        $pattern='/^([\x{4E00}-\x{9FA5}\x{F900}-\x{FA2D}])+学院$/u';
        if(preg_match($pattern,$school)){
            return true;
        }else{
            return false;
        }
    }

//  检查部门：
//    1.汉字；
//    2.以“部”结尾
    public static function checkDepartment($department){
        $pattern='/^([\x{4E00}-\x{9FA5}\x{F900}-\x{FA2D}])+部$/u';
        if(preg_match($pattern,$department)){
            return true;
        }else{
            return false;
        }
    }


//  检查密码：
//    1.英文，数字，特殊字符@$!%*?&.·#^
//    2.长度：6-18
    public static function checkPassword($password){
        $pattern='/^[a-zA-Z\d@$!%*?&.·#^]{6,18}$/';
        if(preg_match($pattern,$password)){
            return true;
        }else{
            return false;
        }
    }
}
