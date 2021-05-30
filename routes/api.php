<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//忘记密码
Route::any('forgetPassword','PeopleController@forgetPasswordModel');


//显示所有人员——百步梯通讯录
Route::any('queryInitial','PeopleController@queryInitialModel')->middleware('checkLoginMiddleware');
//搜索框查询1——百步梯通讯录
Route::any('queryInfo','PeopleController@queryInfoModel')->middleware('checkLoginMiddleware');
//搜索框查询2——百步梯通讯录（修改状态）
Route::any('queryInfoAdmin','PeopleController@queryInfoAdminModel')->middleware('checkAdminMiddleware');
//管理员获取他人信息——百步梯通讯录（修改状态）
Route::any('queryAdmin','PeopleController@queryAdminModel')->middleware('checkAdminMiddleware');
//批量删除人员——百步梯通讯录（修改状态）
Route::any('delete','PeopleController@deleteModel')->middleware('checkAdminMiddleware');


//点击某人名字查询其信息——详细信息
Route::any('query','PeopleController@queryModel')->middleware('checkLoginMiddleware');



// 登录
Route::post('login','UserController@login');
// 注册
Route::post('register','UserController@register');
// 修改信息
Route::put('update','UserController@update')->middleware('checkLoginMiddleware');
// 获取个人信息
Route::get('user','UserController@user')->middleware('checkLoginMiddleware');
// 注销
Route::get('logout','UserController@logout');
