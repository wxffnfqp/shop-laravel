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

Route::get('users/{user}', function (App\User $user) {
    dd($user);
});
Route::post('/user/{id}', 'UserController@getUser');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'cart'
], function ($router) {
    Route::post('add_car', 'CartController@add_car');
    Route::post('my_car', 'CartController@my_car');
    Route::post('up_car', 'CartController@up_car');
    Route::post('del', 'CartController@del');
    Route::post('myCarTwo', 'CartController@myCarTwo');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'goods'
], function ($router) {
    Route::get('goods_category','GoodsController@goods_category');
    Route::get('goods_floor','GoodsController@floor');
    Route::get('goods', 'GoodsController@goods');
    Route::get('goods', 'GoodsController@goods');
    Route::post('one_goods', 'GoodsController@one_goods');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'address'
], function ($router) {
    Route::post('areashow','AddressController@areashow');
    Route::post('add','AddressController@add');
    Route::post('show','AddressController@show');
    Route::post('del','AddressController@del');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'order'
], function ($router) {
    Route::post('add','OrderController@add');
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'pay'
], function ($router) {
    Route::get('index','PayController@index');
    Route::any('notify','PayController@notify');
    Route::get('return','PayController@return');
});



