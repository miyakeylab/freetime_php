<?php

return [

    /*
    |--------------------------------------------------------------------------
    | メインの言語ファイル(英語)
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
                    '1' => 'Male',
                    '2' => 'Female',
                    ],         // 性別

    'offer_state'=>['0' => "",
                  '1' => "Request",
                  '2' => "Approval pending",
                  '3' => "Approved"],// オファー状態
    /*
    |--------------------------------------------------------------------------
    | resources/views/auth/login.blade.php
    |--------------------------------------------------------------------------
    */
    'login_sns_login_title' => ' SNS Login',
    'login_sns_go' => ' google+ Login　　　',
    'login_sns_fb' => ' Facebook Login 　　',
    'login_sns_tw' => ' Twitter Login　　　　',
    'login_sns_gi' => ' Github Login　　　　',
    'login_mail_title' => ' Mail Login',
    'login_mail' => 'E-Mail Address',
    'login_pass' => 'Password',
    'login_button_label' => 'Login',
    'login_forget' => 'forget your password?',
    /*
    |--------------------------------------------------------------------------
    | resources/views/auth/register.blade.php
    |--------------------------------------------------------------------------
    */
    'register_title' => ' Register',
    'register_name' => 'name',
    'register_pass_conf' => 'Confirm Password',
    'register_button_label' => 'Register',
    /*
    |--------------------------------------------------------------------------
    | resources/views/nav.blade.php
    |--------------------------------------------------------------------------
    */
    'nav_welcome' => 'Welcome, :name',
     /*
    |--------------------------------------------------------------------------
    | resources/views/my_schedule.blade.php
    |--------------------------------------------------------------------------
    */
    'schedule_create_button' => ' Create new schedule',
    'schedule_modal_close' => 'close',
    'schedule_modal_title' => 'Schedule Register',
    'schedule_modal_date' => 'Date',
    'schedule_modal_start' => "Start",
    'schedule_modal_end' => "End",
    'schedule_modal_content_title' => "Contents", 
    'schedule_modal_content' => "Contents",        
    'schedule_modal_close_button' => "Close", 
    'schedule_modal_reg_button' => "Register",
    'schedule_modal_disp' => 'Scheduled Display',
    /*
    |--------------------------------------------------------------------------
    | resources/views/friend.blade.php
    |--------------------------------------------------------------------------
    */
    'friend_list' => 'Friends List',
    'friend_request_list' => 'Friends Application List',
    'friend_add' => ' Add Friend',
    'friend_ng_Button' => ' Reject',
    'friend_user_list' => "User List",
    'friend_request_Button' => " Request",
    'friend_request_receiving' => " Request Reciving", 
    'friend_request_pending' => " Request Pending",   
    /*
    |--------------------------------------------------------------------------
    | resources/views/offer.blade.php
    |--------------------------------------------------------------------------
    */
    'offerCerate' => ' Make Offer',
    'recOfferList' => 'Offer List',
    'offerTimeStart' => 'Start：',
    'offerTimeEnd' => 'End：',
    'offerNgButton' => ' Reject',
    'reqOfferList' => 'Pending Offer List',
    /*
    |--------------------------------------------------------------------------
    | resources/views/group.blade.php
    |--------------------------------------------------------------------------
    */
    'group_create_button' => ' Create new group',
    'group_list' => 'Group List',
    'group_leave_button' => ' Leave',
    'group_request_list' => 'Group Request List',
    'group_ng_Button' => ' Reject',
    'group_add_Button' => " Join",
    'group_admin' => "Administrator：",
    'group_modal_title' => "Create new group",
    'group_modal_close_button' => "Close",
    'group_modal_content' => "Contents",
    'group_modal_name' => "Group Name", 
];
