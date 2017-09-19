<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Friend;
use App\Group;
use App\Groupuser;
use App\Schedule;
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
        $mySchedule = Schedule::where('user_id','=',Auth::user()->id)
        ->whereDate('start_time', $dt->toDateString())
        ->whereDate('end_time', $dt->toDateString())
        ->get();
        $groups = Groupuser::where('groupusers.user_id',Auth::user()->id)
        ->join('groups', 'groupusers.user_group_id', '=', 'groups.id')
        ->join('userdetails', 'userdetails.user_id', '=', 'groups.administrator_id')
        ->get(["groups.id as master_id","group_img","group_name"]);
        
        Log::info('スケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour);
        return view('my_schedule',['now' => $now,
        'hour' => $hour,
        'friends' => $friends,
        'user' => $user, 
        'mySchedule' => $mySchedule, 
        'groups' => $groups]);
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
        
        
        Log::info('スケジュール登録表示 ID:'.Auth::user()->id.' 開始日付:'.$request->schedule_start.' 終了日付:'.$request->schedule_end);
        
        $dt_start = new Carbon($request->schedule_start);
        $dt_end = new Carbon($request->schedule_end);
        $dt_start_gmt = new Carbon($request->schedule_start);
        $dt_end_gmt = new Carbon($request->schedule_end);        
        $timeId = 0;
        $diff = Config::get('const.TIME_ZONE_MGT_DIFF')[$timeId];
        if($diff > 0)
        {   $dt_start_gmt->subHour($diff);
            $dt_end_gmt->subHour($diff);  

        }else {
                    
            $diff *= -1;
            $dt_start_gmt->addHour($diff);
            $dt_end_gmt->addHour($diff);
        }
        
        
        $schedule = new Schedule;
        $schedule->user_id = Auth::user()->id;      //ユーザーID
        $schedule->my_time_id = $timeId;            //時間ID
        $schedule->start_time = $dt_start;         //スケジュール開始時間
        $schedule->end_time=$dt_end;                //スケジュール終了時間
        $schedule->start_time_gmt = $dt_start_gmt;     //スケジュール開始時間(GMT)
        $schedule->end_time_gmt = $dt_end_gmt;       //スケジュール終了時間(GMT)
        if($request->schedule_content === null)
        {
            $schedule->content = "";            //スケジュール内容
        }else{
            $schedule->content = $request->schedule_content;            //スケジュール内容
        }
        
        
        if($request->colors == "Default")
        {
            $schedule->category_id=0;        //カテゴリーID
        }else if($request->colors == "Primary")
        {
            $schedule->category_id=1;        //カテゴリーID
        }else if($request->colors == "Success")
        {
            $schedule->category_id=2;        //カテゴリーID
        }else if($request->colors == "Info")
        {
            $schedule->category_id=3;        //カテゴリーID
        }else if($request->colors == "Warning")
        {
            $schedule->category_id=4;        //カテゴリーID
        }else if($request->colors == "Danger")
        {
            $schedule->category_id=5;        //カテゴリーID
        }else
        {
            $schedule->category_id=0;        //カテゴリーID
        }
        
        
        if($request->schedule_title === null)
        {
            $schedule->title="";              //スケジュールタイトル
        }else{
            $schedule->title=$request->schedule_title;              //スケジュールタイトル
            
        }
        $schedule->pat_id=0;             //パターンID
        $schedule->schedule_img="";        //スタンプレイアウト      
        $schedule->save();
        
        return $this->MainView();
    }
    
}
