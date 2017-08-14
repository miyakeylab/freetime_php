<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Socialite;

class AuthController extends Controller
{
    public function redirectToProvider($provider) 
    {
        return Socialite::driver($provider)->redirect();
    }
    
    public function handleProviderCallback($provider) 
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true); //Auth にソーシャル 情 報 を 預 けてログイン
        return redirect('/home'); //★★ 認 証 後 に 表示 したいページを 指定 ★★
    }
    
    public function findOrCreateUser($user, $provider) { 
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) { 
            return $authUser; 
            
        } 
        
        return User::create([   'name' => $user->name, 
                                'email' => $user->email, 
                                'provider' => $provider, 
                                'provider_id' => $user->id ]);
    }
}
