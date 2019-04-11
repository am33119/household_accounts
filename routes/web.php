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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('bop/create', 'Admin\BopController@add');
    Route::post('bop/create', 'Admin\BopController@create');
    Route::get('bop/expense', 'Admin\BopController@showExpense');
    Route::get('bop/income', 'Admin\BopController@showIncome');
    Route::get('bop/total', 'Admin\BopController@showTotal');
    Route::get('bop/edit', 'Admin\BopController@edit');
    Route::post('bop/edit', 'Admin\BopController@update');
    Route::get('bop/delete', 'Admin\BopController@delete');


    Route::get('category/create', 'Admin\CategoryController@add');
    Route::post('category/create', 'Admin\CategoryController@create');
    Route::post('category/edit', 'Admin\CategoryController@update');
    Route::post('category/delete', 'Admin\CategoryController@delete');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
