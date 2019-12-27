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

//操作者登陆——登录
Route::any('operatorLogin','PeopleController@loginModel');
//添加人员——注册
Route::any('insert','PeopleController@insertModel');
//忘记密码
Route::any('forgetPassword','PeopleController@forgetPasswordModel');
//操作者注销
Route::any('operatorLogout','PeopleController@logoutModel');


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
//修改人员——百步梯通讯录（修改状态）
Route::any('update','PeopleController@updateAdminModel');


//点击某人名字查询其信息——详细信息
Route::any('query','PeopleController@queryModel')->middleware('checkLoginMiddleware');
//获取自己信息——个人信息
Route::any('queryNumber','PeopleController@queryNumberModel')->middleware('checkLoginMiddleware');
//自己修改自己信息——个人信息
Route::any('updatePeople','PeopleController@updatePeopleModel');


//没课表查询
Route::any('free','TimetableController@noClassModel')->middleware('checkLoginMiddleware');
//没课表录入
Route::any('insertFree','TimetableController@insertNoClassModel')->middleware('checkLoginMiddleware');

