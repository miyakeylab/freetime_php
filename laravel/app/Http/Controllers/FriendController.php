<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
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
        return view('friend', ['friends' => $friends]);
    }
    
    /**
     * 友達登録
     **/
    public function FriendRegist($friend_id) 
    {
        return redirect('friend'); 
    }
}
