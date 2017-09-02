<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userdetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'user_id',      // ユーザーID
        'user_name',    // ユーザー名
        'user_content',// ユーザーコメント
        'user_sex',    // ユーザー性別(0:無し/1:男/2:女)
        'user_img',    // ユーザー画像(default:no_image)
        'user_birthday',             // ユーザー生年月日
    ];
}
