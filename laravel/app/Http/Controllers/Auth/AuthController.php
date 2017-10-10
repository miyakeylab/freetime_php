<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Userdetail;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Socialite;
use Illuminate\Support\Facades\Config;

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
        try
        {
            $user = Socialite::driver($provider)->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true); //Authにソーシャル情報を預けてログイン
            return redirect('/home'); //認証後に表示したいページを指定
        }catch(\Exception $e){
            return redirect('/login'); //認証前に表示したいページを指定
        }
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
        
        $newUser = User::create(['name' => $user->name, 
                                'email' => $user->email, 
                                'provider' => $provider, 
                                'provider_id' => $user->id ]);
                                
        Userdetail::create(['user_id' => $newUser->id,      // ユーザーID
                'user_name' => $user->name,                 // ユーザー名
                'user_content' => "",                       // ユーザーコメント
                'user_sex' => 0,                            // ユーザー性別(0:無し/1:男/2:女)
                'user_img' =>  Config::get('const.DEF_ICON'),   // ユーザー画像(default:no_image)
                'user_birthday' =>  Carbon::now(),             // ユーザー生年月日
                'user_privacy' => 0,        // ユーザープライバシー(0:ロック/666:全表示)
                                ]);
        // ユーザーアカウント作成
        return $newUser;
    }
}
