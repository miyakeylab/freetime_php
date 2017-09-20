<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Offer;
use App\Friend;
use App\Schedule;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  オファー画面表示 
     **/
    public function MainView() {
        Log::info('オファー画面表示 ID:'.Auth::user()->id);
        $offers = Offer::where('client_user_id',Auth::user()->id)
        ->where('state', Config::get('const.OFFER_REQ'))
        ->join('userdetails', 'offers.master_user_id', '=', 'userdetails.user_id')
        ->get(["offers.id as master_id","start_time","end_time","user_name","title"]);
        $offerReqs = Offer::where('master_user_id',Auth::user()->id)->where('state', Config::get('const.OFFER_REQ'))->join('userdetails', 'offers.client_user_id', '=', 'userdetails.user_id')->get();
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        return view('offer', ['offers' => $offers,'friends' => $friends,'offerReqs' => $offerReqs]);
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
        return redirect('offer'); 
    }
    
    /**
     * オファーリクエストOK
     **/
    public function OfferRequestOk(Request $request) 
    {
        Log::info('オファーリクエストOK オファーID:'.$request->offer_res_ok_id);
        
        $offer = Offer::find($request->offer_res_ok_id);
        $offer->state = Config::get('const.OFFER_OK');
        $offer->save();
        
        $schedule = new Schedule;
        $schedule->user_id = Auth::user()->id;      //ユーザーID
        $schedule->my_time_id = $offer->my_time_id;            //時間ID
        $schedule->start_time = $offer->start_time;         //スケジュール開始時間
        $schedule->end_time = $offer->end_time;                //スケジュール終了時間
        $schedule->start_time_gmt = $offer->start_time_gmt;     //スケジュール開始時間(GMT)
        $schedule->end_time_gmt = $offer->end_time_gmt;       //スケジュール終了時間(GMT)
        $schedule->content = $offer->content;            //スケジュール内容
        $schedule->category_id = $offer->category_id;         //カテゴリーID
        $schedule->title = $offer->title;              //スケジュールタイトル

        $schedule->pat_id=$offer->pat_id;             //パターンID
        $schedule->schedule_img=$offer->schedule_img;        //スタンプレイアウト      
        $schedule->save();
        
        $schedule_master = new Schedule;
        $schedule_master->user_id = $offer->master_user_id;      //ユーザーID
        $schedule_master->my_time_id = $offer->my_time_id;            //時間ID
        $schedule_master->start_time = $offer->start_time;         //スケジュール開始時間
        $schedule_master->end_time = $offer->end_time;                //スケジュール終了時間
        $schedule_master->start_time_gmt = $offer->start_time_gmt;     //スケジュール開始時間(GMT)
        $schedule_master->end_time_gmt = $offer->end_time_gmt;       //スケジュール終了時間(GMT)
        $schedule_master->content = $offer->content;            //スケジュール内容
        $schedule_master->category_id = $offer->category_id;         //カテゴリーID
        $schedule_master->title = $offer->title;              //スケジュールタイトル

        $schedule_master ->pat_id=$offer->pat_id;             //パターンID
        $schedule_master ->schedule_img=$offer->schedule_img;        //スタンプレイアウト      
        $schedule_master ->save();
        
        return redirect('offer'); 
    }
    
    /**
     * オファーリクエストNG
     **/
    public function OfferRequestNg(Request $request) 
    {
        Log::info('オファーリクエストNG オファーID:'.$request->offer_res_ng_id);
        
        $offer = Offer::find($request->offer_res_ng_id);
        $offer->state = Config::get('const.OFFER_NG');
        $offer->save();
        
        return redirect('offer'); 
    }    
    
}
