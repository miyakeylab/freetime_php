<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
        
    /**
     *  言語切り替え処理 
     */
    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Log::info('言語切り替え 言語:'.$lang);
            Session::put('applocale', $lang);
        }
        
        Log::info('テスト');
        if (Auth::guest())
        {
            Log::info('ログイン前');
            return Redirect::back();
        }
        else
        {
            Log::info('ログイン後');
            return redirect()->action('ScheduleController@MainView');
        }
    }
}
