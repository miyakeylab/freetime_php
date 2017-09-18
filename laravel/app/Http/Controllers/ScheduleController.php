<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Friend;
use App\Group;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  スケジュール画面表示 
     **/
    public function MainView() {
        $dt = Carbon::now();
        $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF')["0"]);
        $now = $dt->year."/".str_pad($dt->month, 2, 0, STR_PAD_LEFT)."/".str_pad($dt->day, 2, 0, STR_PAD_LEFT);
        $hour = $dt->hour;
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        $user = User::find(Auth::user()->id)->userdetail()->first();

        Log::info('スケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour);
        return view('my_schedule',['now' => $now,'hour' => $hour,'friends' => $friends,'user' => $user]);
    }
    
    /**
     *  ユーザースケジュール画面表示 
     **/
    public function UserScheduleView($id) {
        $dt = Carbon::now();
        $month = $dt->month;
        $day = $dt->day;
        $user = User::join('userdetails', 'users.id', '=', 'userdetails.user_id')->where('users.id','=',$id)->first();
        Log::info('ユーザースケジュール画面表示 ID:'.Auth::user()->id.' 表示ユーザーID:'.$id.' 月:'.$month);
        return view('user_schedule',['month' => $month,'day' => $day, 'user' =>$user]);
    }
    
    /**
     * グループスケジュール表示
     * @param group_id グループID
     */
    public function GroupScheduleView($group_id) 
    {
        $dt = Carbon::now();
        $month = $dt->month;
        $day = $dt->day; 
        $maxDay = Config::get('const.MONTH_DAY_MAX')[$dt->month];
        $group = Group::where('id','=',$group_id)->first();
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
    
        return view('group_schedule',['month' => $month,'day' => $day,'maxDay' => $maxDay,'group' => $group,'friends' => $friends]); 
    }    
    
     /**
     *  スケジュール登録 
     **/
    public function CreateSchedule(Request $request) {
        $dt = Carbon::now();
        $now = $dt->month."/".$dt->day;
        $hour = $dt->hour;
        
        Log::info('スケジュール登録表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour);
        return view('my_schedule',['now' => $now,'hour' => $hour]);
    }
    
}
