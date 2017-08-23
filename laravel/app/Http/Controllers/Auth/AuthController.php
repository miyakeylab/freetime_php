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
    
    /**
     * コールバック処理メソッド
     **/
    public function handleProviderCallback($provider) 
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true); //Authにソーシャル情報を預けてログイン
        return redirect('/home'); //認証後に表示したいページを指定
    }
    
    /**
     * ユーザー処理
     **/
    public function findOrCreateUser($user, $provider) { 
        $authUser = User::where('provider_id', $user->id)->first();
        
        // 既に存在している場合
        if ($authUser) { 
            return $authUser; 
            
        } 
        
        // nullで名前が戻ってきた時
        if($user->name == null)
        {
            // ゲストをユーザー名にする
            $user->name = "guest";
        }
        
        // ユーザーアカウント作成
        return User::create([   'name' => $user->name, 
                                'email' => $user->email, 
                                'provider' => $provider, 
                                'provider_id' => $user->id ]);
    }
}
