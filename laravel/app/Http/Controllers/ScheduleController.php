<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     *  メイン画面表示
     **/   
    public  function RootView() {
    
        return view('my_schedule' );
    }
    /**
     *  スケジュール画面表示 
     **/
    public function ScheView() {
        return view('my_schedule');
    }
}
