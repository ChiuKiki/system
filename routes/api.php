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


// 登录
Route::post('login','UserController@login');
// 注册
Route::post('register','UserController@register');
// 修改信息
Route::post('update','UserController@update');
// 获取个人信息
Route::post('user','UserController@user');

