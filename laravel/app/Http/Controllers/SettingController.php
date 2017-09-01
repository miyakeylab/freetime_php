<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  設定画面表示 
     **/
    public function MainView() {
        Log::info('設定画面表示 ID:'.Auth::user()->id);
        $user = User::join('userdetails', 'users.id', '=', 'userdetails.user_id')->where('users.id',Auth::user()->id)->first();
        return view('setting', ['user' => $user]);
    }
}
