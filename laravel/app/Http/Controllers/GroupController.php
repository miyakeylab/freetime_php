<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Groupuser;
use App\Groupoffer;
use App\Userdetail;
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
        foreach($request->addUser as $user)
        {
            $groupoffer = new Groupoffer;
            $groupoffer->master_user_id = Auth::user()->id;            //フレンドーユーザーID
            $groupoffer->client_user_id = $user;    //フレンドクライアントユーザーID
            $groupoffer->state = Config::get('const.OFFER_REQ'); //オファー状況 
            $groupoffer->group_id = $request->group_id;        //グループID
            $groupoffer->save();
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
}
