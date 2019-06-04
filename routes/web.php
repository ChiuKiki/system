<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');



//操作者登陆
Route::get('operatorLogin','PeopleController@checkModel');
//人员查询
Route::get('query/{choice}','PeopleController@readModel');
//添加人员
Route::any('insert','PeopleController@insertModel');
//修改人员
Route::any('update','PeopleController@updateModel');

//操作者注册
Route::any('register','PeopleController@insert_administrator_Model');