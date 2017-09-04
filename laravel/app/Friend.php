<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
            'user_id',         //ユーザーID
            'friend_user_id',  //友達ユーザーID
    ];
}
