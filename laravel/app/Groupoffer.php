<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupoffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
            'master_user_id',//フレンドーユーザーID
            'client_user_id',//フレンドクライアントユーザーID
            'group_id',       //グループID
            'state',         //オファー状況
    ];
}
