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
    'nav_lang' => 'Language:',
    'nav_time' => 'Timezone:',
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
    'schedule_friend_list' => 'Friend Schedule List',
    'schedule_group_list' => 'Group Schedule List',
    'schedule_modal_share' => 'Share',
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
    'friend_request_message' => "message",
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
    'offerOkButton' => " Approve",
    'reqOfferList' => 'Pending Offer List',
    'offerCheck' => "offer",
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
    /*
    |--------------------------------------------------------------------------
    | resources/views/group_schedule.blade.php
    |--------------------------------------------------------------------------
    */
    'gr_sche_cre_button' => ' Create new schedule',
    'gr_user_add_button' => ' Add User',
    'gr_user_add_title' => 'Add User',
    'gr_user_list' => 'Group Users List',
    /*
    |--------------------------------------------------------------------------
    | resources/views/setting.blade.php 
    |--------------------------------------------------------------------------
    */
    'setting_title' => 'User Profile',
    /*
    |--------------------------------------------------------------------------
    | resources/views/marge_schedule.blade.php 
    |--------------------------------------------------------------------------
    */
    'marge_schedule' => 'marge schedule',
    'marge' => ' marge',
    'my_schedule' => 'my schedule',
    /*
    |--------------------------------------------------------------------------
    | timezone
    |--------------------------------------------------------------------------
    */    
    'TIME_ZONE_NAME' => [
                        '0' => "Japan",
                        '1' => "America (Hawaii)",
                        '2' => "America (Los Angeles, San Francisco, Las Vegas)",
                        '3' => "America (Phoenix, Denver, Salt Lake City)",
                        '4' => "America (Chicago, Houston, Dallas, New Orleans)",
                        '5' => "America (New York, Boston, Atlanta, Miami)",
                        '6' => "Argentina",
                        '7' => "Ecuador",
                        '8' => "Canada (Vancouver, British Columbia))",
                        '9' => "Canada (Banff, Calgary, Alberta)",
                        '10' => "Canada (Manitoba)",
                        '11' => "Canada (Toronto, Ottawa, Ontario)",
                        '12' => "Canada (Quebec, Montréal (Quebec))",
                        '13' => "Cuba",
                        '14' => "Guatemala",
                        '15' => "Jamaica",
                        '16' => "Chile (mainland of Chile)",
                        '17' => "Chile (Easter Island)",
                        '18' => "Peru",
                        '19' => "Brazil (Sao Paulo, Rio de Janeiro)",
                        '20' => "Mexico (Mexico City, Cancun)",
                        '21' => "India",
                        '22' => "Indonesia (Jakarta)",
                        '23' => "Indonesia (Bali)",
                        '24' => "South Korea",
                        '25' => "Cambodia",
                        '26' => "Singapore",
                        '27' => "Nepal",
                        '28' => "Pakistan",
                        '29' => "Vietnam",
                        '30' => "Thai",
                        '31' => "China (including Hong Kong and Macao)",
                        '32' => "Malaysia",
                        '33' => "Maldives",
                        '34' => "Australia (Sydney, Melbourne, Cairns, Brisbane, Gold Coast)",
                        '35' => "Australia (Ayers Rock, Adelaide)",
                        '36' => "Australia (Perth)",
                        '37' => "Guam / Saipan",
                        '38' => "New Caledonia",
                        '39' => "New Zealand",
                        '40' => "Papua New Guinea",
                        '41' => "Palau",
                        '42' => "Fiji",
                        '43' => "Tahiti (French Polynesia)",
                        '44' => "United Kingdom",
                        '45' => "Italy",
                        '46' => "Austria",
                        '47' => "Netherlands",
                        '48' => "Greece",
                        '49' => "Croatia",
                        '50' => "Switzerland",
                        '51' => "Sweden",
                        '52' => "Spain",
                        '53' => "Slovak",
                        '54' => "Slovenia",
                        '55' => "Czech",
                        '56' => "Danish",
                        '57' => "Germany",
                        '58' => "Norway",
                        '59' => "Hungary",
                        '60' => "Finland",
                        '61' => "France",
                        '62' => "Belgium",
                        '63' => "Poland",
                        '64' => "Portugal",
                        '65' => "Malta",
                        '66' => "Monaco",
                        '67' => "Liechtenstein",
                        '68' => "Luxembourg",
                        '69' => "Russia (Moscow, St. Petersburg, Sochi)",
                        '70' => "Russia (Khabarovsk, Vladivostok)",
                        '71' => "United Arab Emirates (Dubai)",
                        '72' => "Israel",
                        '73' => "Iran",
                        '74' => "Egypt",
                        '75' => "Saudi Arabia",
                        '76' => "Syria",
                        '77' => "Tunisia",
                        '78' => "Turkey",
                        '79' => "South Africa",
                        '80' => "Morocco"
                          ],
];
