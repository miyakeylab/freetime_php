<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
            'master_user_id',//オファーユーザーID
            'client_user_id',//オファークライアントユーザーID
            'state',         //オファー状況
            'my_time_id',         //時間ID
            'start_time',         //スケジュール開始時間
            'end_time',           //スケジュール終了時間
            'start_time_gmt',     //スケジュール開始時間(GMT)
            'end_time_gmt',       //スケジュール終了時間(GMT)
            'content',            //スケジュール内容
            'category_id',        //カテゴリーID
            'title',              //スケジュールタイトル
            'pat_id',             //パターンID
            'schedule_img'        //スタンプレイアウト

    ];
}
