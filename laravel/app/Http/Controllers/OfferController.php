<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App;
use Auth;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     *  オファー画面表示 
     **/
    public function MainView() {
        Log::info('オファー画面表示 ID:'.Auth::user()->id);
        $offers = Offer::where('client_user_id',Auth::user()->id)->get();
        App::setLocale('ja');
        return view('offer', ['offers' => $offers]);
    }
    
    /**
     * オファー作成
     **/
    public function OfferCreate($content) 
    {
        return redirect('offer'); 
    }
}
