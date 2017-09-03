<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Userdetail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'provider' => "", 
            'provider_id' => "",
        ]);
      Userdetail::create(['user_id' => $newUser->id,      // ユーザーID
            'user_name' => $newUser->name,                 // ユーザー名
            'user_content' => "",                       // ユーザーコメント
            'user_sex' => 0,                            // ユーザー性別(0:無し/1:男/2:女)
            'user_img' => "css/assets/img/user_icon/no_icon.jpg",   // ユーザー画像(default:no_image)
            'user_birthday' =>  Carbon::now(),             // ユーザー生年月日
                            ]);      
        return $newUser;
    }
}
