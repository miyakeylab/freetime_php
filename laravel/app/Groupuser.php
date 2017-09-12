<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupuser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
            'user_id',//ユーザーID
            'user_group_id',//グループID
    ];
}
