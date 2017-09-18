<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupschedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');     //グループID
            $table->unsignedInteger('my_time_id');  //時間ID
            $table->datetime('start_time');         //スケジュール開始時間
            $table->datetime('end_time');           //スケジュール終了時間
            $table->datetime('start_time_gmt');     //スケジュール開始時間(GMT)
            $table->datetime('end_time_gmt');       //スケジュール終了時間(GMT)
            $table->string('title');                //スケジュールタイトル
            $table->string('content');              //スケジュール内容
            $table->unsignedInteger('category_id'); //カテゴリーID
            $table->unsignedInteger('pat_id');      //パターンID
            $table->string('schedule_img');         //スタンプレイアウト
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupschedules');
    }
}
