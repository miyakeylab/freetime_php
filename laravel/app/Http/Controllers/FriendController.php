<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\User;
use Auth;
use Illuminate\Support\Facades\Log;

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
        $friends = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        $friendOffers = Friend::join('users', 'friends.friend_user_id', '=', 'users.id')->join('userdetails', 'friends.friend_user_id', '=', 'userdetails.user_id')->where('friends.user_id',Auth::user()->id)->get();
        Log::info('ユーザー数前');
        $users = User::where('id','!=',Auth::user()->id)->get();
        Log::info('ユーザー数:'.count($users));
        return view('friend', ['friends' => $friends,'friendOffers' => $friendOffers,'users' => $users]);
    }
    
    /**
     * 友達登録
     **/
    public function FriendRegist($friend_id) 
    {
        return redirect('friend'); 
    }
}
