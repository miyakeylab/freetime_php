<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groupuser;
use App\Groupoffer;
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
        $groups = Groupuser::where('groupusers.user_id',Auth::user()->id)->join('groups', 'groupusers.user_group_id', '=', 'groups.id')->get();
        $group_offer_count = Groupoffer::where('client_user_id',Auth::user()->id)->where('state', Config::get('const.OFFER_REQ'))->get();
        return view('group', ['groups' => $groups,'group_offer_count' => $group_offer_count]);
    }
    
    /**
     * グループ作成
     */
    public function GroupCreate(Request $request) 
    {
        // 以下グループIDはDBのIDを使用する
        return redirect('group_schedule/1'); 
    }
    
    /**
     * グループ友達追加
     */
    public function GroupAddFriend(Request $request) 
    {
        // 以下グループIDはポストで受けるようにする
        return redirect('group_schedule/1'); 
    }
}
