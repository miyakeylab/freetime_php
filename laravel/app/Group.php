<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'administrator_id',//グループID
        'group_name',      //グループ名
        'group_img',       // グループ画像(default:no_image) 
    ];
}
