<?php

return [

    /*
    |--------------------------------------------------------------------------
    | メインの言語ファイル
    |--------------------------------------------------------------------------
    |
    */
    /*
    |--------------------------------------------------------------------------
    | 共通系
    |--------------------------------------------------------------------------
    */
    'user_sex' => [
                    '0' => '',
                    '1' => '男性',
                    '2' => '女性',
                    ],         // 性別

    'offer_state'=>['0' => "",
                  '1' => "申請中",
                  '2' => "承認待ち",
                  '3' => "承認済み"],// オファー状態
                  
    /*
    |--------------------------------------------------------------------------
    | resources/views/auth/login.blade.php
    |--------------------------------------------------------------------------
    */
    'login_sns_login_title' => ' SNSログイン',
    'login_sns_go' => ' google+ アカウントでログイン　　　',
    'login_sns_fb' => ' Facebook アカウントでログイン 　　',
    'login_sns_tw' => ' Twitterアカウントでログイン　　　　',
    'login_sns_gi' => ' Githubアカウントでログイン　　　　',
    'login_mail_title' => ' メールアドレスログイン',
    'login_mail' => 'E-Mail アドレス',
    'login_pass' => 'パスワード',
    'login_button_label' => 'ログイン',
    'login_forget' => 'パスワードをお忘れですか?',
    /*
    |--------------------------------------------------------------------------
    | resources/views/auth/register.blade.php
    |--------------------------------------------------------------------------
    */
    'register_title' => ' 新規登録',
    'register_name' => '名前',
    'register_pass_conf' => 'パスワード確認',
    'register_button_label' => ' 新規登録',
    /*
    |--------------------------------------------------------------------------
    | resources/views/nav.blade.php
    |--------------------------------------------------------------------------
    */
    'nav_welcome' => 'ようこそ:nameさん',
    /*
    |--------------------------------------------------------------------------
    | resources/views/my_schedule.blade.php
    |--------------------------------------------------------------------------
    */
    'schedule_create_button' => ' スケジュール新規作成',
    'schedule_modal_close' => '閉じる',
    'schedule_modal_title' => 'スケジュール登録',
    'schedule_modal_date' => '日時',
    'schedule_modal_start' => "開始",
    'schedule_modal_end' => " 終了",
    'schedule_modal_content_title' => "内容", 
    'schedule_modal_content' => "内容",        
    'schedule_modal_close_button' => "閉じる", 
    'schedule_modal_reg_button' => "登録",
    'schedule_modal_disp' => 'スケジュール表示',
    /*
    |--------------------------------------------------------------------------
    | resources/views/friend.blade.php
    |--------------------------------------------------------------------------
    */
    'friend_list' => '友達一覧',
    'friend_request_list' => '友達申請一覧',
    'friend_add' => ' 友達追加',
    'friend_ng_Button' => ' 拒否',
    'friend_user_list' => "ユーザー一覧",
    'friend_request_Button' => " 友達リクエスト",
    'friend_request_receiving' => " リクエスト受信中", 
    'friend_request_pending' => " リクエスト申請中",
    /*
    |--------------------------------------------------------------------------
    | resources/views/offer.blade.php
    |--------------------------------------------------------------------------
    */
    'offerCerate' => ' オファー作成',
    'recOfferList' => '受領オファー一覧',
    'offerTimeStart' => '開始：',
    'offerTimeEnd' => '終了：',
    'offerNgButton' => " 拒否",
    'reqOfferList' => "申請中オファー一覧",

];
