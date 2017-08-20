<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;

class GoogleApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  連携画面表示 
     **/
    public function MainView() {
        Log::info('連携画面表示 ID:'.Auth::user()->id);
        return view('my_google_api');
    }
    

}
