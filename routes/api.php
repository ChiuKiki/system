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
Route::any('operatorLogin','PeopleController@checkModel');
//操作者注册
Route::any('register','PeopleController@insert_administrator_Model');


//人员查询
Route::any('query','PeopleController@readModel');
//添加人员
Route::any('insert','PeopleController@insertModel');
//修改人员
Route::any('update','PeopleController@updateModel');

