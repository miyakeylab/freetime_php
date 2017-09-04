<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Friendoffer;
use App\Offer;
use Auth;
use Illuminate\Support\Facades\Config;

class NavLayoutComposer
{
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();
        if($user !== null)
        {
            $friend_offer_count = Friendoffer::where('client_user_id',Auth::user()->id)->where('state', Config::get('const.FRIEND_OFFER_REQ'))->get();
            $offer_count = Offer::where('client_user_id',Auth::user()->id)->where('state', Config::get('const.OFFER_REQ'))->get();
            $view->with('friend_offer_count', $friend_offer_count)->with('offer_count', $offer_count);
        }
    }
}