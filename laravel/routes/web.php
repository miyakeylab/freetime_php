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

/**
 * ユーザースケジュール表示 
 */ 
Route::get('/user_schedule/{id}','ScheduleController@UserScheduleView');
/** 
* スケジュール登録 
*/ 
Route::post('/my_schedule/set','ScheduleController@CreateSchedule');

Auth::routes();
/** 
* HOME表示 
*/ 
Route::get('/home', 'HomeController@index')->name('home');
/** 
* 友達表示 
*/ 
Route::get('/friend','FriendController@MainView');
/**
 * 友達リクエスト
 */ 
Route::post('/friend/offer', 'FriendController@FriendRegist');
/**
 * 友達リクエストOK
 */ 
Route::post('/friend/reaponse/ok', 'FriendController@FriendRequestOk');
/**
 * 友達リクエストNG
 */ 
Route::post('/friend/reaponse/ng', 'FriendController@FriendRequestNg');
/** 
* グループ表示 
*/ 
Route::get('/group','GroupController@MainView');
/**
 * グループ作成
 */ 
Route::post('/group/create','GroupController@GroupCreate');
/**
 * グループスケジュール表示 
 */ 
Route::get('/group_schedule/{group_id}','ScheduleController@GroupScheduleView');
/** 
* オファー表示 
*/ 
Route::get('/offer','OfferController@MainView');
/**
 * オファー作成
 */ 
Route::get('/offer/{content}','OfferController@OfferCreate');

/** 
* 連携表示 
*/ 
Route::get('/google_api','GoogleApiController@MainView');

/** 
* 設定表示 
*/ 
Route::get('/setting','SettingController@MainView');


/**
 * SNSログインリダイレクト
 */
Route::get('auth/{provide}','Auth\AuthController@redirectToProvider');
/**
 * SNSログインコールバック
 */
Route::get('auth/{provide}/callback','Auth\AuthController@handleProviderCallback');
/**
 * 言語切替
 */
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);