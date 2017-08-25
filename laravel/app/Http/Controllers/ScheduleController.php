<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use App\User;
use Illuminate\Support\Facades\Log;

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
        $now = $dt->month."/".$dt->day;
        $hour = $dt->hour;
        Log::info('スケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour);
        return view('my_schedule',['now' => $now,'hour' => $hour]);
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
    
}
