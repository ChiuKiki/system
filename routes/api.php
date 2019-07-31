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
Route::any('operatorLogin','PeopleController@loginModel')->middleware('web');
//添加人员——注册
Route::any('insert','PeopleController@insertModel')->middleware('web');
//忘记密码
Route::any('forgetPassword','PeopleController@forgetPasswordModel')->middleware('web');
//操作者注销
Route::any('operatorLogout','PeopleController@logoutModel')->middleware('web');

//搜索框查询——百步梯通讯录
Route::any('queryInfo','PeopleController@queryInfoModel')->middleware('web');
//搜索框查询——百步梯通讯录（修改状态）
Route::any('queryInfoAdmin','PeopleController@queryInfoAdminModel')->middleware('web');
//批量删除人员——百步梯通讯录（修改状态）
Route::any('delete','PeopleController@deleteModel')->middleware('web');
//修改人员——百步梯通讯录（修改状态）
Route::any('update','PeopleController@updateAdminModel')->middleware('web');
//点击某人名字查询其信息——详细信息
Route::any('query','PeopleController@queryModel')->middleware('web');
//修改人员——百步梯通讯录（修改状态）
Route::any('updatePeople','PeopleController@updatePeopleModel')->middleware('web');
//没课表查询
Route::any('free','TimetableController@noClassModel')->middleware('web');

