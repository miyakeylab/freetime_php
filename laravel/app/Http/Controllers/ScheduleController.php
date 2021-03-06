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
use App\Groupschedule;
use App\Schedule;
use App\Offer;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  スケジュール画面初期ルート
     **/
    public function MainView() {
        $dt = Carbon::now();
        $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF')["0"]);
        $hour = $dt->hour;
        return $this->ScheduleDisp($dt,$hour,0);
    }
    
    /**
     *  ユーザースケジュール画面初期ルート 
     **/
    public function UserScheduleView($id) {
        $dt = Carbon::now();
        $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF')["0"]);
        return $this->UserScheduleDisp($id,$dt,0);
    }
     /**
     *  ユーザースケジュール画面表示 
     **/
    public function UserScheduleDisp($id,$dt,$my_timezone) {       
        $month = $dt->month;
        $year = $dt->year;
        $maxMonth = $dt->daysInMonth;
        $getDate = Carbon::create($dt->year, $dt->month, 1);
        
        $user = User::join('userdetails', 'users.id', '=', 'userdetails.user_id')->where('users.id','=',$id)->first();
        for ($i=1;$i<=$maxMonth;$i++)
        {
            $mySchedule[] = Schedule::where('user_id','=',$id)
            ->whereDate('start_time_gmt', $getDate->toDateString())
            ->get();
            $getDate->addDay();
        }
        
        if(Auth::user()->id == $id)
        {
            $feed ="myFeed";
            $modal = "staticModal";
        }else
        {
            $feed ="friendFeed";
            $modal = "friendModal";
            
        }
        
        Log::info('ユーザースケジュール画面表示 ID:'.Auth::user()->id.' 表示ユーザーID:'.$id.' 月:'.$month.' スケジュール:'.count($mySchedule));
        return view('user_schedule',['year' => $year,
                                        'month' => $month, 
                                        'user' =>$user,
                                        'maxMonth' => $maxMonth,
                                        'mySchedule' => $mySchedule,
                                        'feed' => $feed,
                                        'modal' => $modal,
                                        'myid'=> $id,
                                        'my_timezone' => $my_timezone]);
    }
    
    /**
     * グループスケジュール表示
     * @param group_id グループID
     */
    public function GroupScheduleView($group_id) 
    {
        $dt = Carbon::now();
        $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF')["0"]);
        $hour = $dt->hour;
        return $this->GroupScheduleDisp($dt,$hour,$group_id);
        
 
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
        $timeId =  $request->my_timezone;
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
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
        
        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $timeId;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }
    
     /**
     *  グループスケジュール登録 
     **/
    public function GroupScheduleCreate(Request $request) {
        
        Log::info('グループスケジュール登録表示 ID:'.Auth::user()->id.' 開始日付:'.$request->schedule_start.' 終了日付:'.$request->schedule_end);
        
        $dt_start = new Carbon($request->schedule_start);
        $dt_end = new Carbon($request->schedule_end);
        $dt_start_gmt = new Carbon($request->schedule_start);
        $dt_end_gmt = new Carbon($request->schedule_end);        
        
        $timeId =  $request->my_timezone;
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        $schedule = new Groupschedule;
        $schedule->group_id = $request->group_id;      //ユーザーID
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
        $schedule->pat_id=0;                //パターンID
        $schedule->schedule_img="";        //スタンプレイアウト      
        $schedule->save();
        
        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        $my_timezone = 0;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }    

     /**
     *  スケジュール取り込み 
     **/
    public function CreateShareSchedule(Request $request) {
        
        
        Log::info('スケジュール取り込み表示 ID:'.Auth::user()->id.' 開始日付:'.$request->friend_schedule_start.' 終了日付:'.$request->friend_schedule_end.' colors:'.$request->friend_colors);
        
        $dt_start = new Carbon($request->friend_schedule_start);
        $dt_end = new Carbon($request->friend_schedule_end);
        $dt_start_gmt = new Carbon($request->friend_schedule_start);
        $dt_end_gmt = new Carbon($request->friend_schedule_end);        
        $timeId =  $request->my_timezone;
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        
        $schedule = new Schedule;
        $schedule->user_id = Auth::user()->id;      //ユーザーID
        $schedule->my_time_id = $timeId;            //時間ID
        $schedule->start_time = $dt_start;         //スケジュール開始時間
        $schedule->end_time=$dt_end;                //スケジュール終了時間
        $schedule->start_time_gmt = $dt_start_gmt;     //スケジュール開始時間(GMT)
        $schedule->end_time_gmt = $dt_end_gmt;       //スケジュール終了時間(GMT)
        if($request->friend_schedule_content === null)
        {
            $schedule->content = "";            //スケジュール内容
        }else{
            $schedule->content = $request->friend_schedule_content;            //スケジュール内容
        }
        
        
        if($request->friend_colors == "Default")
        {
            $schedule->category_id=0;        //カテゴリーID
        }else if($request->friend_colors == "Primary")
        {
            $schedule->category_id=1;        //カテゴリーID
        }else if($request->friend_colors == "Success")
        {
            $schedule->category_id=2;        //カテゴリーID
        }else if($request->friend_colors == "Info")
        {
            $schedule->category_id=3;        //カテゴリーID
        }else if($request->friend_colors == "Warning")
        {
            $schedule->category_id=4;        //カテゴリーID
        }else if($request->friend_colors == "Danger")
        {
            $schedule->category_id=5;        //カテゴリーID
        }else
        {
            $schedule->category_id=0;        //カテゴリーID
        }
        
        
        if($request->friend_schedule_title === null)
        {
            $schedule->title="";              //スケジュールタイトル
        }else{
            $schedule->title=$request->friend_schedule_title;              //スケジュールタイトル
            
        }
        $schedule->pat_id=0;             //パターンID
        $schedule->schedule_img="";        //スタンプレイアウト      
        $schedule->save();
        
        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        $my_timezone = 0;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }
    /**
     *  スケジュール前日表示 
     **/
    public function PrevScheduleView(Request $request) {
        $dt = new Carbon($request->now_day);
        $dt->subDay(1);
        $dt_now = Carbon::now();        
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['2']);
        }
        
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        $my_timezone = $request->my_timezone;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }
    /**
     *  スケジュール翌日表示 
     **/
    public function NextScheduleView(Request $request) {
        $dt = new Carbon($request->now_day);
        $dt->addDay(1);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->my_timezone]['2']);
        }        
        Log::info('$dt_now '.$dt_now.' $dt '.$dt);
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $request->my_timezone;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    } 
    /**
     *  スケジュール表示 
     **/
    public function ScheduleDisp($dt,$setHour,$my_timezone) { 
        
        $now = $dt->year."/".str_pad($dt->month, 2, 0, STR_PAD_LEFT)."/".str_pad($dt->day, 2, 0, STR_PAD_LEFT);
        $pre_dt = $dt->copy()->subDay();
        $now_pre = $pre_dt->year."/".str_pad($pre_dt->month, 2, 0, STR_PAD_LEFT)."/".str_pad($pre_dt->day, 2, 0, STR_PAD_LEFT);
        
        $dt_where_pre = $dt->copy()->subDay(2);
        $dt_where_nex = $dt->copy()->addDay(2);
        
        Log::info('$dt_where_pre'.$dt_where_pre->toDateString().' $dt_where_nex'.$dt_where_nex->toDateString());
  
        
        $hour = $setHour;
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        $user = User::find(Auth::user()->id)->userdetail()->first();
        $mySchedule = Schedule::where('user_id','=',Auth::user()->id)
        ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
        ->get();
                
        foreach($mySchedule as $schTemp)
        {
            Log::info('スケジュールID:'.$schTemp->id);

        }        
        //友達スケジュール一覧
        $friendSchedule = array();
        // ID抽出
        foreach($friends as $friend)
        {
            $friendSchedule[] = Schedule::where('user_id','=',$friend->friend_user_id)
                ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
                ->get();
        }
        
        $groups = Groupuser::where('groupusers.user_id',Auth::user()->id)
        ->join('groups', 'groupusers.user_group_id', '=', 'groups.id')
        ->join('userdetails', 'userdetails.user_id', '=', 'groups.administrator_id')
        ->get(["groups.id as master_id","group_img","group_name"]);
        
        $groupSchedule = array();
        // ID抽出
        foreach($groups as $group)
        {
            $groupSchedule[] = Groupschedule::where('group_id','=',$group->master_id)
                ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
                ->get();
        }        
        Log::info('スケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour.' TimeZone:'.$my_timezone);
        return view('schedule_main',['now' => $now,
        'hour' => $hour,
        'friends' => $friends,
        'user' => $user, 
        'mySchedule' => $mySchedule, 
        'groups' => $groups,
        'friendSchedule' => $friendSchedule,
        'groupSchedule' => $groupSchedule,
        'my_timezone' => $my_timezone,
        'now_pre' => $now_pre]);     
    }
    /**
     *  スケジュール表示 
     **/
    public function GroupScheduleDisp($dt,$setHour,$group_id) { 
        $now = $dt->year."/".str_pad($dt->month, 2, 0, STR_PAD_LEFT)."/".str_pad($dt->day, 2, 0, STR_PAD_LEFT);
        $hour = $setHour;
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        $groupfriends = Groupuser::where('groupusers.user_group_id',$group_id)
        ->join('userdetails', 'userdetails.user_id', '=', 'groupusers.user_id')
        ->get();
        $mySchedule = Groupschedule::where('group_id','=',$group_id)
        ->whereDate('start_time_gmt', $dt->toDateString())
        ->get();
                
        //友達スケジュール一覧
        $friendSchedule = array();
        // ID抽出
        foreach($groupfriends as $groupfriend)
        {
            $friendSchedule[] = Schedule::where('user_id','=',$groupfriend->user_id)
                ->whereDate('start_time_gmt', $dt->toDateString())
                ->get();
        }
        
        $group = Group::where('id','=',$group_id)->first();       
        Log::info('グループスケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour);
        
        return view('group_schedule',['now' => $now,
        'hour' => $hour,
        'groupfriends' => $groupfriends,
        'friends' => $friends,
        'mySchedule' => $mySchedule, 
        'group' => $group,
        'friendSchedule' => $friendSchedule]);     
    }
    
    /**
     * オファー作成
     **/
    public function OfferCreate(Request $request) 
    {
        Log::info('オファー作成 ID:'.Auth::user()->id);
    
        $dt_start = new Carbon($request->schedule_start);
        $dt_end = new Carbon($request->schedule_end);
        $dt_start_gmt = new Carbon($request->schedule_start);
        $dt_end_gmt = new Carbon($request->schedule_end);        

        $timeId =  $request->my_timezone;        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }        
        $offer = new Offer;
        $offer->master_user_id = Auth::user()->id;//オファーユーザーID
        $offer->client_user_id = $request->offer_friend_id;//オファークライアントユーザーID
        $offer->state = Config::get('const.OFFER_REQ');         //オファー状況
        $offer->my_time_id = $timeId;            //時間ID
        $offer->start_time = $dt_start;         //スケジュール開始時間
        $offer->end_time=$dt_end;                //スケジュール終了時間
        $offer->start_time_gmt = $dt_start_gmt;     //スケジュール開始時間(GMT)
        $offer->end_time_gmt = $dt_end_gmt;       //スケジュール終了時間(GMT)
        if($request->schedule_content === null)
        {
            $offer->content = "";            //スケジュール内容
        }else{
            $offer->content = $request->schedule_content;            //スケジュール内容
        }
        
        
        if($request->colors == "Default")
        {
            $offer->category_id=0;        //カテゴリーID
        }else if($request->colors == "Primary")
        {
            $offer->category_id=1;        //カテゴリーID
        }else if($request->colors == "Success")
        {
            $offer->category_id=2;        //カテゴリーID
        }else if($request->colors == "Info")
        {
            $offer->category_id=3;        //カテゴリーID
        }else if($request->colors == "Warning")
        {
            $offer->category_id=4;        //カテゴリーID
        }else if($request->colors == "Danger")
        {
            $offer->category_id=5;        //カテゴリーID
        }else
        {
            $offer->category_id=0;        //カテゴリーID
        }
        
        if($request->schedule_title === null)
        {
            $offer->title="";              //スケジュールタイトル
        }else{
            $offer->title=$request->schedule_title;              //スケジュールタイトル
            
        }
        $offer->pat_id=0;                //パターンID
        $offer->schedule_img="";        //スタンプレイアウト      
        $offer->save();

        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $timeId;
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }
     /**
     * オファー作成
     **/
    public function OfferCreateUser(Request $request) 
    {
        Log::info('オファー作成 ID:'.Auth::user()->id);
    
        $dt_start = new Carbon($request->schedule_start);
        $dt_end = new Carbon($request->schedule_end);
        $dt_start_gmt = new Carbon($request->schedule_start);
        $dt_end_gmt = new Carbon($request->schedule_end);        

        $timeId =  $request->my_timezone;        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }        
        $offer = new Offer;
        $offer->master_user_id = Auth::user()->id;//オファーユーザーID
        $offer->client_user_id = $request->offer_friend_id;//オファークライアントユーザーID
        $offer->state = Config::get('const.OFFER_REQ');         //オファー状況
        $offer->my_time_id = $timeId;            //時間ID
        $offer->start_time = $dt_start;         //スケジュール開始時間
        $offer->end_time=$dt_end;                //スケジュール終了時間
        $offer->start_time_gmt = $dt_start_gmt;     //スケジュール開始時間(GMT)
        $offer->end_time_gmt = $dt_end_gmt;       //スケジュール終了時間(GMT)
        if($request->schedule_content === null)
        {
            $offer->content = "";            //スケジュール内容
        }else{
            $offer->content = $request->schedule_content;            //スケジュール内容
        }
        
        
        if($request->colors == "Default")
        {
            $offer->category_id=0;        //カテゴリーID
        }else if($request->colors == "Primary")
        {
            $offer->category_id=1;        //カテゴリーID
        }else if($request->colors == "Success")
        {
            $offer->category_id=2;        //カテゴリーID
        }else if($request->colors == "Info")
        {
            $offer->category_id=3;        //カテゴリーID
        }else if($request->colors == "Warning")
        {
            $offer->category_id=4;        //カテゴリーID
        }else if($request->colors == "Danger")
        {
            $offer->category_id=5;        //カテゴリーID
        }else
        {
            $offer->category_id=0;        //カテゴリーID
        }
        
        if($request->schedule_title === null)
        {
            $offer->title="";              //スケジュールタイトル
        }else{
            $offer->title=$request->schedule_title;              //スケジュールタイトル
            
        }
        $offer->pat_id=0;                //パターンID
        $offer->schedule_img="";        //スタンプレイアウト      
        $offer->save();

        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        $my_timezone = $timeId;
        $id = $request->offer_friend_id;
        return $this->UserScheduleDisp($id,$dt,$my_timezone);
    }   
    /**
     * タイムゾーン
     **/
    public function switchTimezone(Request $request)
    {
        Log::info('タイムゾーン切り替え TimeZone:'.$request->timezone);
        $my_timezone = $request->timezone;
        $dt = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->timezone]['0'] == true)
        {
            $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->timezone]['1']);
            $dt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->timezone]['2']);
        }
        else
        {
            $dt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->timezone]['1']);
            $dt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$request->timezone]['2']);
        }
        
        $hour = $dt->hour;

        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }
    /**
     * タイムゾーン(ユーザー)
     **/
    public function switchTimezoneUser(Request $request)
    {
        Log::info('タイムゾーン切り替え TimeZone:'.$request->timezone);
        $my_timezone = $request->timezone;
        $dt = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['0'] == true)
        {
            $dt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
            $dt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
        }
        else
        {
            $dt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['1']);
            $dt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$my_timezone]['2']);
        }
        
        $id = $request->my_id;

        return $this->UserScheduleDisp($id,$dt,$my_timezone);
    }
    
    /**
     * スケジュール削除
     **/
    public function DeleteSchedule(Request $request)
    {
        Log::info('スケジュール削除 id:'.$request->schedule_id);
        
        $del_data = Schedule::find($request->schedule_id);

        $del_data->delete();
        
        $dt = new Carbon($request->now_day_del);
        $dt_now = Carbon::now();
        $timeId = $request->my_timezone_del;
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $timeId;

        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }    
    /**
     * スケジュール更新
     **/
    public function ModSchedule(Request $request)
    {
        Log::info('スケジュール更新 id:'.$request->schedule_id);
        

        $dt_start = new Carbon($request->schedule_start);
        $dt_end = new Carbon($request->schedule_end);
        $dt_start_gmt = new Carbon($request->schedule_start);
        $dt_end_gmt = new Carbon($request->schedule_end);        
        $timeId =  $request->my_timezone;
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            // GMTにするためマイナス
            $dt_start_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_start_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_start_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
            $dt_end_gmt->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_end_gmt->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        
        $schedule = Schedule::find($request->schedule_id);
        
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
        
        $dt = new Carbon($request->now_day);
        $dt_now = Carbon::now();
        
        if(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['0'] == true)
        {
            $dt_now->addHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->addMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        else
        {
            $dt_now->subHour(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['1']);
            $dt_now->subMinutes(Config::get('const.TIME_ZONE_MGT_DIFF_ARRAY')[$timeId]['2']);
        }
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $timeId;

        return $this->ScheduleDisp($dt,$hour,$my_timezone);
    }      
}
