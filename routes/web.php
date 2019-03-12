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

Route::group(['prefix' => 'admin'], function() {
    Route::get('bop/create', 'Admin\BopController@add');
    Route::post('bop/create', 'Admin\BopController@create');
    Rotute::get('bop/expense', 'Admin\BopController@showExpense');
});
