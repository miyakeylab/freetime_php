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
     *  スケジュール画面表示 
     **/
    public function MainView() {
        $dt = Carbon::now();
        $now = $dt->month."/".$dt->day;
        $hour = $dt->hour;
        return view('my_schedule',['now' => $now,'hour' => $hour]);
    }
}
