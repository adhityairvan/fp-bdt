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

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::middleware('auth')->group(function() {
    Route::get('/home', 'TransactionController@index')->name('home');
    Route::prefix('item')->group(function (){
        Route::get('/', 'ItemController@index');
        Route::get('create', 'ItemController@create');
        Route::post('create', 'ItemController@store');
        Route::get('{id}', 'ItemController@edit');
        Route::post('{id}', 'ItemController@update');
        Route::post('{id}/stok', 'ItemController@updateStock');
    });
    Route::prefix('transaction')->group(function (){
       Route::post('/store', 'TransactionController@store');
       Route::get('/list', 'TransactionController@getList');
       Route::post('/delete', 'TransactionController@delete');
    });
    Route::prefix('user')->group(function (){
        Route::get('/', 'UserController@index');
        Route::post('/delete', 'UserController@delete');
        Route::post('/create', 'UserController@create');
    });
});
Route::get('/item/', 'ItemController@index');
