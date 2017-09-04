<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendoffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
            'master_user_id',//フレンドーユーザーID
            'client_user_id',//フレンドクライアントユーザーID
            'state',         //オファー状況
            'content',       //メッセージ内容
    ];
}
