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
// 闭包路由
// Route::get('/', function () {
//     return view('welcome');
// });

Route::domain('www.1905.com')->group(function () {
    // 周测  文章
    Route::prefix('/art')->middleware('CheckToken')->group(function () {
        Route::get('create','Admin\ArtController@create');
        Route::post('store','Admin\ArtController@store');
        Route::get('index','Admin\ArtController@index');
        Route::get('delete/{art_id}','Admin\ArtController@destroy');
        Route::get('edit/{art_id}','Admin\ArtController@edit');
        Route::post('update/{art_id}','Admin\ArtController@update');
        Route::post('checkOnly','Admin\ArtController@checkOnly');
    });


    // 品牌
    Route::prefix('/brand')->group(function () {
        Route::get('create','Admin\BrandController@create');
        Route::post('store','Admin\BrandController@store');
        Route::get('index','Admin\BrandController@index');
        Route::get('delete/{brand_id}','Admin\BrandController@destroy');
        Route::get('edit/{brand_id}','Admin\BrandController@edit');
        Route::post('update/{brand_id}','Admin\BrandController@update');
        Route::post('checkOnly','Admin\BrandController@checkOnly');
    });
    // 管理员
    Route::prefix('/admin')->middleware('auth')->group(function () {
        Route::get('create','Admin\AdminController@create');
        Route::post('store','Admin\AdminController@store');
        Route::get('index','Admin\AdminController@index');
        Route::get('delete/{admin_id}','Admin\AdminController@destroy');
        Route::get('edit/{admin_id}','Admin\AdminController@edit');
        Route::post('update/{admin_id}','Admin\AdminController@update');
        Route::post('checkOnly','Admin\AdminController@checkOnly');
    });

    // 分类
    Route::prefix('/cate')->middleware('auth')->group(function () {
        Route::get('create','Admin\CateController@create');
        Route::post('store','Admin\CateController@store');
        Route::get('index','Admin\CateController@index');
        Route::get('delete/{cate_id}','Admin\CateController@destroy');
        Route::get('edit/{cate_id}','Admin\CateController@edit');
        Route::post('update/{cate_id}','Admin\CateController@update');
        Route::post('checkOnly','Admin\CateController@checkOnly');
    });

    // 商品
    Route::prefix('/goods')->group(function () {
        Route::get('create','Admin\GoodsController@create');
        Route::post('store','Admin\GoodsController@store');
        Route::get('index','Admin\GoodsController@index');
        Route::get('delete/{goods_id}','Admin\GoodsController@destroy');
        Route::get('edit/{goods_id}','Admin\GoodsController@edit');
        Route::post('update/{goods_id}','Admin\GoodsController@update');
        Route::post('checkOnly','Admin\GoodsController@checkOnly');
    });
});
    // 登陆
    // Route::view('/login','login')->name('login');
    // Route::post('/doLogin','RegController@doLogin');
    // // 注册
    // Route::view('/registe','registe');
    // Route::post('/doRegiste','RegController@doRegiste');


// 前台
Route::get('/','Index\IndexController@index');//首页
Route::view('/login','index/login/login');//登陆
Route::post('/login/doLogin','Index\LoginController@doLogin');
Route::view('/reg','index/login/reg');//注册
Route::post('/login/send','Index\LoginController@send');
Route::post('/login/doReg','Index\LoginController@doReg');

Route::prefix('/index')->group(function () {
    Route::any('proinfo/{id}','Index\IndexController@proinfo');
    Route::any('prolist','Index\IndexController@prolist');//全部商品
    Route::any('cart','Index\CartController@cart');//购物车列表
    Route::any('addCart','Index\CartController@addCart');//加入购物车
    Route::any('change','Index\CartController@change');//修改数据库的购买数量
    Route::any('getTotal','Index\CartController@getTotal');//获取小计
    Route::any('getCount','Index\CartController@getCount');//获取总价
    Route::any('cartDel','Index\CartController@cartDel');//点击删除
});
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
