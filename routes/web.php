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

//Route::get('/', function () {
//    return view('index/index');
//});
//Route::get('index','Index\IndexController@index');
//路由参数
Route::get('user/{id}', function ($id) {
    return $id;
});
//路由参数默认值
//Route::get('user/{name?}', function ($name == null) {
//    return $name;
//});
//使用正则匹配一下
Route::get('user/{name?}', function ($name) {
    return $name;
})->where('name','[A-Za-z]+');
//路由使用多个参数
Route::get('user1/{id}/{name?}', function ($id,$name) {
    return $id . '=>' .$name;
})->where(['id'=>'[0-9]+','name','[A-Za-z]+']);
//路由别名
Route::group(['prefix'=>'index','namespace'=>'Index'],function (){
    Route::resource('index','IndexController');
    Route::resource('login','LoginController');
});
Route::get('/index/update','Index\IndexController@update');
Route::get('/index/myshow','Index\IndexController@myshow');
Route::get('/index/add','Index\IndexController@add');
Route::get('/index/loginaction','Index\LoginController@loginaction');
Route::get('/index/delete','Index\IndexController@delete');
Route::get('/index/out','Index\LoginController@out');

//Route::group(['prefix'=>'login','namespace'=>'Index'],function (){
//    Route::get('login','LoginController@index');
//    Route::any('loginaction','LoginController@loginaction');
//});

