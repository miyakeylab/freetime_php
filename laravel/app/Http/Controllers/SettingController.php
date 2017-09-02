<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\Carbon;
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
        $user = User::find(Auth::user()->id)->first();
        $userdetail = User::find(Auth::user()->id)->userdetail()->first();
        $birthday = Carbon::parse($userdetail->user_birthday);
        
        return view('setting', ['user' => $user,'userdetail' => $userdetail,'birthday' => $birthday]);
    }
}
