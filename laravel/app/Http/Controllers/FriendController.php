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
        $friends = Friend::get();
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
