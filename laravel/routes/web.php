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
/** 
* スケジュールホーム
*/ 
Route::get('/', 'ScheduleController@RootView');

/** 
* スケジュール 表示 
*/ 
Route::get('/my_schedule','ScheduleController@ScheView');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * SNSログインリダイレクト
 */
Route::get('auth/{provide}','Auth\AuthController@redirectToProvider');
/**
 * SNSログインコールバック
 */
Route::get('auth/{provide}/callback','Auth\AuthController@handleProviderCallback');