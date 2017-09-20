<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Group;
use App\Groupuser;
use App\Groupoffer;
use App\Userdetail;
use App\Groupschedule;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  グループ画面表示 
     */
    public function MainView() {
        Log::info('グループ画面表示 ID:'.Auth::user()->id);
        $groups = Groupuser::where('groupusers.user_id',Auth::user()->id)
        ->join('groups', 'groupusers.user_group_id', '=', 'groups.id')
        ->join('userdetails', 'userdetails.user_id', '=', 'groups.administrator_id')
        ->get();
        $group_offer_count = Groupoffer::join('groups', 'groupoffers.group_id', '=', 'groups.id')
        ->where('client_user_id',Auth::user()->id)
        ->where('state', Config::get('const.OFFER_REQ'))
        ->get(["groupoffers.id as master_id","group_img","group_name"]);
        return view('group', ['groups' => $groups,'group_offer_count' => $group_offer_count]);
    }
    
    /**
     * グループ作成
     */
    public function GroupCreate(Request $request) 
    {
        $group = new Group;
        $group->administrator_id = Auth::user()->id;  //管理者ID
        $group->group_name = $request->group_name;     //グループ名
        $group->group_img = "css/assets/img/group_icon/g_no_icon.png";       // グループ画像(default:no_image)         
        $group->save();
        
        // グループユーザー作成
        $this->GroupUserCreate($group->id,Auth::user()->id);
        // 以下グループIDはDBのIDを使用する
        return redirect('group_schedule/'.$group->id); 
    }
    
    /**
     * グループ友達申請追加
     */
    public function GroupAddFriend(Request $request) 
    {
        if($request->has('addUser'))
        {
            foreach($request->addUser as $user)
            {
                $groupoffer = new Groupoffer;
                $groupoffer->master_user_id = Auth::user()->id;            //フレンドーユーザーID
                $groupoffer->client_user_id = $user;    //フレンドクライアントユーザーID
                $groupoffer->state = Config::get('const.OFFER_REQ'); //オファー状況 
                $groupoffer->group_id = $request->group_id;        //グループID
                $groupoffer->save();
            }
        }
        // 以下グループIDはポストで受けるようにする
        return redirect('group_schedule/'.$request->group_id); 
    }
    
    /**
     * グループリクエストOK
     **/
    public function GroupRequestOk(Request $request) 
    {
        Log::info('グループリクエストOK グループオファーID:'.$request->group_res_ok_id);
        
        $groupoffer = Groupoffer::find($request->group_res_ok_id);
        $groupoffer->state = Config::get('const.OFFER_OK');
        $groupoffer->save();
        // グループユーザー作成
        $this->GroupUserCreate($groupoffer->group_id,Auth::user()->id);
        return redirect('group'); 
    }
    
    /**
     * グループリクエストNG
     **/
    public function GroupRequestNg(Request $request) 
    {
        Log::info('グループリクエストNG グループオファーID:'.$request->group_res_ng_id);
        
        $groupoffer = Groupoffer::find($request->group_res_ng_id);
        $groupoffer->state = Config::get('const.OFFER_NG');
        $groupoffer->save();
        
        return redirect('group'); 
    }
    /**
     * グループ退会
     **/
    public function GroupOut(Request $request) 
    {
        Log::info('グループ退会 グループID:'.$request->group_out_id);
        
       Groupuser::where('user_id',Auth::user()->id)
                   ->where('user_group_id', $request->group_out_id)
                   ->delete();
                   
        return redirect('group'); 
    }    
    /**
     * グループユーザー作成
     **/
    public function GroupUserCreate($group_id,$user_id) 
    {
        Log::info('グループユーザー作成 group_id:'.$group_id.' user_id:'.$user_id);
        
        $groupuser = new Groupuser;
        $groupuser->user_id = $user_id;
        $groupuser->user_group_id = $group_id;   
        $groupuser->save();
        
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
        
        return redirect('group_schedule/'.$request->group_id); 
    }    
}
