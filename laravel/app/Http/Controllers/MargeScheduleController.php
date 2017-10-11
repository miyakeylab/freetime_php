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

class MargeScheduleController extends Controller
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
        $user_marge_check =  array();
        $group_marge_check = array();
        return $this->ScheduleDisp($dt,$hour,0,$user_marge_check,$group_marge_check);
    }
    /**
     *  スケジュール表示 
     **/
    public function ScheduleDisp($dt,$setHour,$my_timezone,$user_marge_check,$group_marge_check) { 
        
        $now = $dt->year."/".str_pad($dt->month, 2, 0, STR_PAD_LEFT)."/".str_pad($dt->day, 2, 0, STR_PAD_LEFT);
        $dt_where_pre = $dt->copy()->subDay(2);
        $dt_where_nex = $dt->copy()->addDay(2);
        
        $hour = $setHour;
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        $user = User::find(Auth::user()->id)->userdetail()->first();
        $mySchedule = Schedule::where('user_id','=',Auth::user()->id)
        ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
        ->get();
                
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
        
        $margeSchedule = array();
        if(count($group_marge_check) != 0)
        {
            foreach($group_marge_check as $groupTemp)
            {

                $margeSchedule[] = Groupschedule::where('group_id','=',$groupTemp)
                ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
                ->get();
            }   
        }
        if(count($user_marge_check) != 0)
        {
            foreach($user_marge_check as $userTemp)
            {
                $margeSchedule[] = Schedule::where('user_id','=',$userTemp)
                    ->whereBetween('start_time_gmt', array($dt_where_pre->toDateString(),$dt_where_nex->toDateString()))
                    ->get();
            }
        }
        
        Log::info('マージスケジュール画面表示 ID:'.Auth::user()->id.' 日付:'.$now.' 時間:'.$hour.' TimeZone:'.$my_timezone);
        return view('marge_schedule',['now' => $now,
        'hour' => $hour,
        'friends' => $friends,
        'user' => $user, 
        'mySchedule' => $mySchedule, 
        'groups' => $groups,
        'friendSchedule' => $friendSchedule,
        'groupSchedule' => $groupSchedule,
        'my_timezone' => $my_timezone,
        'user_marge_check' => $user_marge_check,
        'group_marge_check' => $group_marge_check,
        'margeSchedule' => $margeSchedule]);     
    }
    /**
     * マージ処理
     **/
    public function MargeRequest(Request $request)
    {
        Log::info('マージ処理 TimeZone:'.$request->timezone);
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
        $user_marge_check =  array();
        $group_marge_check =  array();
        // 存在チェック
        if($request->has('user_marge'))
        {
            foreach($request->user_marge as $user)
            { 
                $user_marge_check[] = $user;
            }
        }
        else
        {
            Log::info('user_margeなし');
        }
        
        // 存在チェック
        if($request->has('group_marge'))
        {
            foreach($request->group_marge as $group)
            { 
                $group_marge_check[] = $group;
            }            
        }
        else
        {
             Log::info('group_margeなし');           
        }
        return $this->ScheduleDisp($dt,$hour,$my_timezone,$user_marge_check,$group_marge_check);
    }
    
    /**
     * タイムゾーン
     **/
    public function switchTimezone(Request $request)
    {
        Log::info('タイムゾーン切り替え(マージ) TimeZone:'.$request->timezone);
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
        $user_marge_check =  array();
        $group_marge_check = array();
        return $this->ScheduleDisp($dt,$hour,$my_timezone,$user_marge_check,$group_marge_check);
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
        $user_marge_check =  array();
        $group_marge_check = array();
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone,$user_marge_check,$group_marge_check);
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
        
        if($dt->isSameDay($dt_now) == true)
        {
            $hour = $dt_now->hour;
        }else
        {
            $hour = 25;
        }
        
        $my_timezone = $request->my_timezone;
        $user_marge_check =  array();
        $group_marge_check = array();
        
        return $this->ScheduleDisp($dt,$hour,$my_timezone,$user_marge_check,$group_marge_check);
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
        
        // 存在チェック
        if($request->has('addUser'))
        {
            foreach($request->addUser as $user)
            {                
                $offer = new Offer;
                $offer->master_user_id = Auth::user()->id;//オファーユーザーID
                $offer->client_user_id = $user;//オファークライアントユーザーID
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
            }        
        }

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
         $user_marge_check =  array();
        $group_marge_check = array();       
        return $this->ScheduleDisp($dt,$hour,$my_timezone,$user_marge_check,$group_marge_check);
    }    
}
