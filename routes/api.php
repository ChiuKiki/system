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

//操作者登陆
Route::any('operatorLogin','PeopleController@loginModel')->middleware('web');
//操作者注销
Route::any('operatorLogout','PeopleController@logoutModel')->middleware('web');
//忘记密码
Route::any('forgetPassword','PeopleController@forgetPasswordModel')->middleware('web');

//人员查询
Route::any('query','PeopleController@queryModel')->middleware('web');
//添加人员
Route::any('insert','PeopleController@insertModel')->middleware('web');
//修改人员
Route::any('update','PeopleController@updateModel')->middleware('web');
//删除人员
Route::any('delete','PeopleController@deleteModel')->middleware('web');
//没课表查询
Route::any('free','TimetableController@noClassModel')->middleware('web');

