<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend; 
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
        $friends = Friend::get();
        return view('my_friend', ['friends' => $friends]);
    }
}
