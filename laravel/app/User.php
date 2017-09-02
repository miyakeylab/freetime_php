<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','provider', 'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * ユーザー詳細(1:1)
     *
     */
    public function userdetail()
    { 
        return $this->hasOne('App\Userdetail','user_id'); 
    }    
    /**
     * スケジュール(1:N)
     *
     */
    public function schedule()
    { 
        return $this->hasMany('App\Schedule','user_id'); 
    }
}
