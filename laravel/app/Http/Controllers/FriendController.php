<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\User;
use App\Friendoffer;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;


class FriendController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  友達画面表示 
     **/
    public function MainView() {
        Log::info('友達画面表示 ID:'.Auth::user()->id);
        // Friends join users join userdetails
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')
                            ->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')
                            ->where('friends.user_id',Auth::user()->id)
                            ->get();
        
        //友達ID一覧
        $friendValue = array();
        // ID抽出
        foreach($friends as $friend)
        {
            $friendValue[] = $friend->friend_user_id;
        }
        Log::info('友達ID一覧 '.print_r($friendValue, true)); 
        
        // 友達申請
        $friendOffers = Friendoffer::join('users', 'friendoffers.master_user_id', '=', 'users.id')
                                    ->join('userdetails', 'friendoffers.master_user_id', '=', 'userdetails.user_id')
                                    ->where('friendoffers.client_user_id',Auth::user()->id)
                                    ->get(["friendoffers.id as master_id","name","user_id","user_img","content"]);

        // 友達有無
        if(count($friendValue) === 0)
        {
            // 友達と自分以外のユーザー
            $users = User::join('userdetails', 'users.id', '=', 'userdetails.user_id')
                            ->where('users.id','!=',Auth::user()->id)
                            ->get();
        }else
        {
            // 友達と自分以外のユーザー
            $users = User::join('userdetails', 'users.id', '=', 'userdetails.user_id')
                            ->where('users.id','!=',Auth::user()->id)
                            ->whereNotIn('users.id',$friendValue)
                            ->get();
        }
    
        //オファー中のユーザー情報
        $RequestingUsers = array();
        foreach($users as $user)
        {

            if(Friendoffer::where('master_user_id',Auth::user()->id)
                            ->where('state', Config::get('const.FRIEND_OFFER_REQ'))
                            ->where('client_user_id', $user->id)
                            ->exists() === true)
            {
                $RequestingUsers[] = $user->id;
            }
 
        }
        Log::info('オファー中のユーザー '.print_r($RequestingUsers, true));     
    
        
        return view('friend', ['friends' => $friends,
                                'friendOffers' => $friendOffers,
                                'users' => $users,
                                'RequestingUsers' => $RequestingUsers]);
    }
    
    /**
     * 友達登録
     **/
    public function FriendRegist(Request $request) 
    {
        Log::info('友達登録画面 ユーザーID:'.$request->friendoffer_id.' メッセージ内容:'.$request->friendoffer_content);
        
        $friendoffer = new Friendoffer;
        $friendoffer->master_user_id = Auth::user()->id;            //フレンドーユーザーID
        $friendoffer->client_user_id = $request->friendoffer_id;    //フレンドクライアントユーザーID
        $friendoffer->state = Config::get('const.FRIEND_OFFER_REQ'); //オファー状況
        if(is_null($request->friendoffer_content) === true)
        {
            $friendoffer->content= "";     //メッセージ内容
        }else
        {
            $friendoffer->content= $request->friendoffer_content;     //メッセージ内容
        }
        $friendoffer->save();
        
        return redirect('friend'); 
    }
        
    /**
     * 友達リクエストOK
     **/
    public function FriendRequestOk(Request $request) 
    {
        Log::info('友達リクエストOK 友達オファーID:'.$request->friend_res_ok_id);
        
        $friendoffer = Friendoffer::find($request->friend_res_ok_id);
        $friendoffer->state = Config::get('const.FRIEND_OFFER_OK');
        $friendoffer->save();
        
        return redirect('friend'); 
    }
    
    /**
     * 友達リクエストNG
     **/
    public function FriendRequestNg(Request $request) 
    {
        Log::info('友達リクエストNG 友達オファーID:'.$request->friend_res_ng_id);
        
        $friendoffer = Friendoffer::find($request->friend_res_ng_id);
        $friendoffer->state = Config::get('const.FRIEND_OFFER_NG');
        $friendoffer->save();
        
        return redirect('friend'); 
    }
}
