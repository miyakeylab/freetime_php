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
Route::get('/', 'ScheduleController@MainView');

/** 
* スケジュール表示 
*/ 
Route::get('/my_schedule','ScheduleController@MainView');

Auth::routes();
/** 
* HOME表示 
*/ 
Route::get('/home', 'HomeController@index')->name('home');
/** 
* 友達表示 
*/ 
Route::get('/my_friend','FriendController@MainView');
/**
 * 友達追加
 */ 
Route::get('/my_friend/{friend_id}','FriendController@FriendRegist');

/** 
* グループ表示 
*/ 
Route::get('/my_group','GroupController@MainView');
/**
 * グループ作成
 */ 
Route::get('/my_group/{group_name}','GroupController@GroupCreate');

/** 
* オファー表示 
*/ 
Route::get('/my_offer','OfferController@MainView');
/**
 * オファー作成
 */ 
Route::get('/my_offer/{content}','OfferController@OfferCreate');
/**
 * SNSログインリダイレクト
 */
Route::get('auth/{provide}','Auth\AuthController@redirectToProvider');
/**
 * SNSログインコールバック
 */
Route::get('auth/{provide}/callback','Auth\AuthController@handleProviderCallback');